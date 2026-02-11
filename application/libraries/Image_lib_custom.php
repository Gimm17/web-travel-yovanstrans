<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Image_lib_custom {
    protected $CI;
    protected $max_width = 1200;
    protected $quality = 80;
    protected $thumb_width = 300;
    protected $thumb_height = 300;

    public function __construct() {
        $this->CI =& get_instance();
    }

    /**
     * Compress and resize an uploaded image
     * @param string $file_path Full path to the image
     * @return bool
     */
    public function compress($file_path) {
        if (!file_exists($file_path)) return false;

        $info = getimagesize($file_path);
        if (!$info) return false;

        $mime = $info['mime'];
        $orig_w = $info[0];
        $orig_h = $info[1];

        // Only resize if larger than max_width
        if ($orig_w <= $this->max_width) {
            // Still compress quality
            return $this->_compress_quality($file_path, $mime);
        }

        // Calculate new dimensions
        $ratio = $this->max_width / $orig_w;
        $new_w = $this->max_width;
        $new_h = (int)($orig_h * $ratio);

        // Use GD library
        $src = $this->_create_from($file_path, $mime);
        if (!$src) return false;

        $dst = imagecreatetruecolor($new_w, $new_h);
        
        // Preserve transparency for PNG
        if ($mime === 'image/png') {
            imagealphablending($dst, false);
            imagesavealpha($dst, true);
        }

        imagecopyresampled($dst, $src, 0, 0, 0, 0, $new_w, $new_h, $orig_w, $orig_h);
        $this->_save($dst, $file_path, $mime);
        
        imagedestroy($src);
        imagedestroy($dst);
        return true;
    }

    /**
     * Create a thumbnail
     * @param string $file_path Source image path
     * @param string $thumb_path Destination thumbnail path
     * @return bool
     */
    public function make_thumbnail($file_path, $thumb_path = null) {
        if (!file_exists($file_path)) return false;

        $info = getimagesize($file_path);
        if (!$info) return false;

        if (!$thumb_path) {
            $path_info = pathinfo($file_path);
            $thumb_path = $path_info['dirname'] . '/thumb_' . $path_info['basename'];
        }

        $src = $this->_create_from($file_path, $info['mime']);
        if (!$src) return false;

        $dst = imagecreatetruecolor($this->thumb_width, $this->thumb_height);

        // Crop-to-fit
        $src_w = $info[0]; $src_h = $info[1];
        $src_ratio = $src_w / $src_h;
        $dst_ratio = $this->thumb_width / $this->thumb_height;

        if ($src_ratio > $dst_ratio) {
            $crop_w = (int)($src_h * $dst_ratio);
            $crop_h = $src_h;
            $crop_x = (int)(($src_w - $crop_w) / 2);
            $crop_y = 0;
        } else {
            $crop_w = $src_w;
            $crop_h = (int)($src_w / $dst_ratio);
            $crop_x = 0;
            $crop_y = (int)(($src_h - $crop_h) / 2);
        }

        imagecopyresampled($dst, $src, 0, 0, $crop_x, $crop_y, $this->thumb_width, $this->thumb_height, $crop_w, $crop_h);
        $this->_save($dst, $thumb_path, $info['mime']);
        
        imagedestroy($src);
        imagedestroy($dst);
        return true;
    }

    private function _create_from($path, $mime) {
        switch ($mime) {
            case 'image/jpeg': return imagecreatefromjpeg($path);
            case 'image/png':  return imagecreatefrompng($path);
            case 'image/webp': return imagecreatefromwebp($path);
            default: return false;
        }
    }

    private function _save($image, $path, $mime) {
        switch ($mime) {
            case 'image/jpeg': imagejpeg($image, $path, $this->quality); break;
            case 'image/png':  imagepng($image, $path, 8); break;
            case 'image/webp': imagewebp($image, $path, $this->quality); break;
        }
    }

    private function _compress_quality($path, $mime) {
        $src = $this->_create_from($path, $mime);
        if (!$src) return false;
        $this->_save($src, $path, $mime);
        imagedestroy($src);
        return true;
    }
}
