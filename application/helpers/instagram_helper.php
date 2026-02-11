<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Instagram Helper
 * Fetches post data (title, content, image) from a public Instagram post URL
 * by scraping Open Graph meta tags from the page HTML.
 * Uses file_get_contents (no cURL dependency).
 */

/**
 * Validate and normalize an Instagram post URL.
 * Accepts URLs like:
 *   https://www.instagram.com/p/XXXXX/
 *   https://www.instagram.com/reel/XXXXX/
 *   https://instagram.com/p/XXXXX/?igsh=...
 *
 * @param string $url
 * @return string|false  Cleaned URL or false if invalid
 */
function ig_validate_url($url) {
    $url = trim($url);
    // Match instagram.com/p/... or instagram.com/reel/...
    if (preg_match('#^https?://(www\.)?instagram\.com/(p|reel)/([A-Za-z0-9_-]+)#', $url, $m)) {
        // Return a clean canonical URL
        return 'https://www.instagram.com/' . $m[2] . '/' . $m[3] . '/';
    }
    return false;
}

/**
 * Fetch Instagram post data from a public post URL.
 *
 * @param string $url  A valid Instagram post/reel URL
 * @return array  ['success' => bool, 'data' => [...], 'error' => string]
 */
function ig_fetch_post($url) {
    $clean_url = ig_validate_url($url);
    if (!$clean_url) {
        return ['success' => false, 'error' => 'URL Instagram tidak valid. Gunakan format: https://www.instagram.com/p/XXXXX/'];
    }

    // Fetch the page HTML
    $html = _ig_http_fetch($clean_url);
    if (!$html) {
        return ['success' => false, 'error' => 'Gagal mengambil data dari Instagram. Coba lagi nanti.'];
    }

    // Parse OG meta tags
    $og = _ig_parse_og_tags($html);

    if (empty($og['og:title']) && empty($og['og:description'])) {
        return ['success' => false, 'error' => 'Tidak dapat membaca data postingan. Pastikan akun dan postingan bersifat publik.'];
    }

    // Extract useful data
    $title = '';
    $content = '';

    // og:title is usually like "Username on Instagram: 'caption preview...'"
    // og:description contains a more complete caption
    if (!empty($og['og:description'])) {
        $desc = html_entity_decode($og['og:description'], ENT_QUOTES, 'UTF-8');
        $content = _ig_extract_caption($desc);
    }

    // Generate title from first line of content (max 100 chars)
    if (!empty($content)) {
        $first_line = strtok($content, "\n");
        $title = mb_strlen($first_line) > 100 ? mb_substr($first_line, 0, 100) . '...' : $first_line;
    } elseif (!empty($og['og:title'])) {
        $title = html_entity_decode($og['og:title'], ENT_QUOTES, 'UTF-8');
    }

    // Get image URL
    $image_url = !empty($og['og:image']) ? html_entity_decode($og['og:image'], ENT_QUOTES, 'UTF-8') : '';

    // Download the image to server
    $image_filename = '';
    if ($image_url) {
        $image_filename = _ig_download_image($image_url);
    }

    return [
        'success' => true,
        'data' => [
            'title'          => $title,
            'content'        => $content ?: strip_tags($og['og:title'] ?? ''),
            'image_url'      => $image_url,
            'image_filename' => $image_filename,
            'source_url'     => $clean_url,
        ]
    ];
}

/**
 * Fetch a URL using file_get_contents with stream context.
 * Uses Twitterbot User-Agent so Instagram serves OG meta tags
 * (Instagram returns a JS-rendered SPA for normal browser UAs).
 */
function _ig_http_fetch($url) {
    $opts = [
        'http' => [
            'method'          => 'GET',
            'header'          => "Accept: text/html,application/xhtml+xml\r\nAccept-Language: id-ID,id;q=0.9\r\nUser-Agent: Twitterbot/1.0",
            'timeout'         => 15,
            'follow_location' => true,
            'max_redirects'   => 5,
            'ignore_errors'   => true,
        ],
        'ssl' => [
            'verify_peer'      => false,
            'verify_peer_name' => false,
        ],
    ];

    $context = stream_context_create($opts);
    $response = @file_get_contents($url, false, $context);

    if ($response === false) {
        return false;
    }

    // Check HTTP status from $http_response_header (auto-populated by file_get_contents)
    if (isset($http_response_header) && is_array($http_response_header)) {
        $status_line = $http_response_header[0];
        if (preg_match('/\d{3}/', $status_line, $m)) {
            if ((int)$m[0] >= 400) {
                return false;
            }
        }
    }

    return $response;
}

/**
 * Parse Open Graph meta tags from HTML.
 */
function _ig_parse_og_tags($html) {
    $og = [];

    // Match <meta property="og:..." content="..."> tags
    if (preg_match_all('/<meta\s+(?:property|name)=["\']og:([^"\']+)["\']\s+content=["\']([^"\']*)["\'][^>]*>/i', $html, $matches, PREG_SET_ORDER)) {
        foreach ($matches as $match) {
            $og['og:' . $match[1]] = $match[2];
        }
    }

    // Also try reversed attribute order: content="..." property="og:..."
    if (preg_match_all('/<meta\s+content=["\']([^"\']*)["\'][^>]*(?:property|name)=["\']og:([^"\']+)["\'][^>]*>/i', $html, $matches, PREG_SET_ORDER)) {
        foreach ($matches as $match) {
            if (!isset($og['og:' . $match[2]])) {
                $og['og:' . $match[2]] = $match[1];
            }
        }
    }

    return $og;
}

/**
 * Extract caption text from Instagram's og:description.
 * Removes the preamble like "X likes, X comments - Username on Instagram: "
 */
function _ig_extract_caption($desc) {
    $patterns = [
        '/^\d+[\d,.\s]*likes?,?\s*\d+[\d,.\s]*comments?\s*[-\x{2013}\x{2014}]\s*[^:]+:\s*["\x{201C}\x{201D}]?(.*?)["\x{201C}\x{201D}]?\s*$/su',
        '/^[^:]+on Instagram:\s*["\x{201C}\x{201D}]?(.*?)["\x{201C}\x{201D}]?\s*$/su',
        '/^[^:]+shared a (?:post|photo|video|reel) on Instagram:\s*["\x{201C}\x{201D}]?(.*?)["\x{201C}\x{201D}]?\s*$/su',
    ];

    foreach ($patterns as $pattern) {
        if (preg_match($pattern, $desc, $m)) {
            return trim($m[1]);
        }
    }

    return trim($desc);
}

/**
 * Download an image from URL and save to assets/uploads/.
 * Uses file_get_contents (no cURL dependency).
 *
 * @param string $image_url
 * @return string  Saved filename, or empty string on failure
 */
function _ig_download_image($image_url) {
    // Decode HTML entities in URL
    $image_url = html_entity_decode($image_url, ENT_QUOTES, 'UTF-8');

    $opts = [
        'http' => [
            'method'          => 'GET',
            'header'          => "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36",
            'timeout'         => 30,
            'follow_location' => true,
            'max_redirects'   => 5,
            'ignore_errors'   => true,
        ],
        'ssl' => [
            'verify_peer'      => false,
            'verify_peer_name' => false,
        ],
    ];

    $context = stream_context_create($opts);
    $image_data = @file_get_contents($image_url, false, $context);

    if ($image_data === false || strlen($image_data) < 1000) {
        return '';
    }

    // Determine extension from response headers
    $ext = 'jpg';
    if (isset($http_response_header) && is_array($http_response_header)) {
        foreach ($http_response_header as $header) {
            if (stripos($header, 'Content-Type:') === 0) {
                $ct = strtolower(trim(substr($header, 13)));
                if (strpos($ct, 'png') !== false) $ext = 'png';
                elseif (strpos($ct, 'webp') !== false) $ext = 'webp';
                elseif (strpos($ct, 'gif') !== false) $ext = 'gif';
                break;
            }
        }
    }

    // Also check URL extension as fallback
    if (preg_match('/\.(jpg|jpeg|png|webp|gif)/i', parse_url($image_url, PHP_URL_PATH), $m)) {
        $url_ext = strtolower($m[1]);
        if ($url_ext === 'jpeg') $url_ext = 'jpg';
        $ext = $url_ext;
    }

    $filename = 'ig_' . time() . '_' . mt_rand(100, 999) . '.' . $ext;
    $upload_path = FCPATH . 'assets/uploads/' . $filename;

    if (@file_put_contents($upload_path, $image_data) !== false) {
        return $filename;
    }

    return '';
}
