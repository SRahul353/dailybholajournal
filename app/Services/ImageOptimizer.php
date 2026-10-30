<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;

class ImageOptimizer
{
    /**
     * Optimize and convert an uploaded image to WebP format.
     *
     * @param UploadedFile $file
     * @param string $destinationFolder Relative to public_path() (e.g. 'uploads' or 'uploads/opinions')
     * @param int $maxWidth Max width in pixels (default: 1200)
     * @param int $quality WebP quality percentage (default: 82)
     * @return string Relative path from public_path()
     */
    public static function uploadAndConvertToWebP(UploadedFile $file, string $destinationFolder = 'uploads', int $maxWidth = 1200, int $quality = 82): string
    {
        $targetDir = public_path($destinationFolder);
        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0755, true);
        }

        $baseName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $cleanBase = preg_replace('/[^a-zA-Z0-9_-]/', '', $baseName) ?: 'image';
        $filename = time() . '_' . uniqid() . '_' . $cleanBase . '.webp';
        $fullPath = $targetDir . DIRECTORY_SEPARATOR . $filename;

        // Try GD WebP conversion if supported
        if (extension_loaded('gd') && function_exists('imagewebp')) {
            try {
                $image = null;
                $mime = $file->getMimeType();

                switch ($mime) {
                    case 'image/jpeg':
                    case 'image/jpg':
                        if (function_exists('imagecreatefromjpeg')) {
                            $image = @imagecreatefromjpeg($file->getRealPath());
                        }
                        break;
                    case 'image/png':
                        if (function_exists('imagecreatefrompng')) {
                            $image = @imagecreatefrompng($file->getRealPath());
                            // Preserve transparency
                            if ($image) {
                                imagepalettetotruecolor($image);
                                imagealphablending($image, true);
                                imagesavealpha($image, true);
                            }
                        }
                        break;
                    case 'image/webp':
                        if (function_exists('imagecreatefromwebp')) {
                            $image = @imagecreatefromwebp($file->getRealPath());
                        }
                        break;
                    case 'image/gif':
                        if (function_exists('imagecreatefromgif')) {
                            $image = @imagecreatefromgif($file->getRealPath());
                        }
                        break;
                }

                if ($image) {
                    $origWidth = imagesx($image);
                    $origHeight = imagesy($image);

                    // Resize if wider than maxWidth
                    if ($origWidth > $maxWidth) {
                        $newWidth = $maxWidth;
                        $newHeight = (int) round(($origHeight / $origWidth) * $maxWidth);
                        $resized = imagescale($image, $newWidth, $newHeight);
                        if ($resized) {
                            imagedestroy($image);
                            $image = $resized;
                        }
                    }

                    // Save as WebP
                    $success = imagewebp($image, $fullPath, $quality);
                    imagedestroy($image);

                    if ($success && file_exists($fullPath)) {
                        return trim($destinationFolder, '/\\') . '/' . $filename;
                    }
                }
            } catch (\Throwable $e) {
                // Fall back to direct file move on any error
            }
        }

        // Fallback: standard file move
        $fallbackFilename = time() . '_' . uniqid() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $file->getClientOriginalName());
        $file->move($targetDir, $fallbackFilename);
        return trim($destinationFolder, '/\\') . '/' . $fallbackFilename;
    }
}
