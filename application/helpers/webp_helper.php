<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * WebP Helper — On-the-fly image conversion to WebP format
 * Converts JPG/PNG uploaded images to WebP for faster page loads.
 * Original files are preserved; WebP versions are cached in assets/uploads/webp/
 */

if (!function_exists('webp_url')) {
    /**
     * Generate URL for WebP version of an uploaded image
     * Falls back to original if WebP not supported or conversion fails
     *
     * @param string $filename Image filename (relative to assets/uploads/)
     * @return string URL to the image (WebP or original)
     */
    function webp_url($filename) {
        if (empty($filename)) return '';

        $CI =& get_instance();

        // Only convert jpg/jpeg/png
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        if (!in_array($ext, ['jpg', 'jpeg', 'png'])) {
            return base_url('assets/uploads/' . $filename);
        }

        // Check if GD supports WebP
        if (!function_exists('imagewebp')) {
            return base_url('assets/uploads/' . $filename);
        }

        // Build WebP cached path
        $webp_dir = FCPATH . 'assets/uploads/webp/';
        $webp_filename = pathinfo($filename, PATHINFO_FILENAME) . '.webp';
        $webp_path = $webp_dir . $webp_filename;
        $original_path = FCPATH . 'assets/uploads/' . $filename;

        // If original doesn't exist, return original URL (will 404 naturally)
        if (!file_exists($original_path)) {
            return base_url('assets/uploads/' . $filename);
        }

        // If WebP cache exists and is newer than original, serve it
        if (file_exists($webp_path) && filemtime($webp_path) >= filemtime($original_path)) {
            return base_url('assets/uploads/webp/' . $webp_filename);
        }

        // Create WebP directory if needed
        if (!is_dir($webp_dir)) {
            @mkdir($webp_dir, 0755, true);
        }

        // Convert to WebP
        $converted = _convert_to_webp($original_path, $webp_path, $ext);

        if ($converted && file_exists($webp_path)) {
            return base_url('assets/uploads/webp/' . $webp_filename);
        }

        // Fallback to original
        return base_url('assets/uploads/' . $filename);
    }
}

if (!function_exists('webp_img')) {
    /**
     * Generate <picture> tag with WebP source and original fallback
     *
     * @param string $filename Image filename
     * @param string $alt Alt text
     * @param string $attrs Extra HTML attributes (e.g. class, style)
     * @return string HTML picture element
     */
    function webp_img($filename, $alt = '', $attrs = '') {
        if (empty($filename)) return '';

        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        $original_url = base_url('assets/uploads/' . $filename);

        // For non-convertible types, just return img
        if (!in_array($ext, ['jpg', 'jpeg', 'png']) || !function_exists('imagewebp')) {
            return '<img src="' . $original_url . '" alt="' . htmlspecialchars($alt) . '" ' . $attrs . '>';
        }

        $webp = webp_url($filename);

        return '<picture>'
             . '<source srcset="' . $webp . '" type="image/webp">'
             . '<img src="' . $original_url . '" alt="' . htmlspecialchars($alt) . '" ' . $attrs . '>'
             . '</picture>';
    }
}

if (!function_exists('_convert_to_webp')) {
    /**
     * Convert image file to WebP format using GD library
     *
     * @param string $source Source file path
     * @param string $dest Destination WebP file path
     * @param string $ext Source file extension
     * @param int $quality WebP quality (0-100)
     * @return bool Success
     */
    function _convert_to_webp($source, $dest, $ext, $quality = 80) {
        try {
            switch ($ext) {
                case 'jpg':
                case 'jpeg':
                    $image = @imagecreatefromjpeg($source);
                    break;
                case 'png':
                    $image = @imagecreatefrompng($source);
                    if ($image) {
                        // Preserve transparency
                        imagepalettetotruecolor($image);
                        imagealphablending($image, true);
                        imagesavealpha($image, true);
                    }
                    break;
                default:
                    return false;
            }

            if (!$image) return false;

            $result = @imagewebp($image, $dest, $quality);
            imagedestroy($image);

            // Sometimes GD creates a file even on failure — check file size
            if ($result && file_exists($dest) && filesize($dest) > 0) {
                return true;
            }

            // Cleanup failed file
            if (file_exists($dest)) @unlink($dest);
            return false;

        } catch (Exception $e) {
            return false;
        }
    }
}
