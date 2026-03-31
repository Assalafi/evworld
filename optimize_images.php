<?php
// Aggressive Image Optimizer for Shared Hosting
$imagePath = __DIR__.'/public/media';  // Path to your images
$maxSize = 300 * 1024;  // 500KB in bytes
$quality = 60;  // Lower quality for JPEG (was 75)
$compression = 8;  // Higher compression for PNG (was 6)
$resizeFactor = 0.8;  // Reduce dimensions to 80% of original (add this new variable)

echo "Starting aggressive image optimization in: $imagePath\n";

// Counters
$processed = 0;
$totalSavings = 0;

// Recursively scan directory
$iterator = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($imagePath),
    RecursiveIteratorIterator::SELF_FIRST
);

foreach ($iterator as $file) {
    if ($file->isDir()) continue;
    
    $path = $file->getPathname();
    $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
    $size = filesize($path);
    
    // Skip if not an image or smaller than max size
    if (!in_array($ext, ['jpg', 'jpeg', 'png']) || $size <= $maxSize) {
        continue;
    }
    
    echo "Processing: " . basename($path) . " (" . round($size/1024) . "KB)... ";
    
    try {
        // Get original dimensions
        list($width, $height) = getimagesize($path);
        
        // Calculate new dimensions
        $newWidth = round($width * $resizeFactor);
        $newHeight = round($height * $resizeFactor);
        
        // Create image resource
        if ($ext === 'png') {
            $image = imagecreatefrompng($path);
            imagesavealpha($image, true); // Preserve transparency
        } else {
            $image = imagecreatefromjpeg($path);
        }
        
        // Create a temporary image with new dimensions
        $tempImage = imagecreatetruecolor($newWidth, $newHeight);
        if ($ext === 'png') {
            imagealphablending($tempImage, false);
            imagesavealpha($tempImage, true);
        }
        
        // Resize (not just copy)
        imagecopyresampled($tempImage, $image, 0, 0, 0, 0, 
                          $newWidth, $newHeight, $width, $height);
        
        // Save optimized image with more aggressive settings
        if ($ext === 'png') {
            imagepng($tempImage, $path, $compression);
        } else {
            imagejpeg($tempImage, $path, $quality);
        }
        
        // Clean up
        imagedestroy($image);
        imagedestroy($tempImage);
        
        // Get new size
        clearstatcache(true, $path);
        $newSize = filesize($path);
        $savings = $size - $newSize;
        $totalSavings += $savings;
        $processed++;
        
        echo "reduced to " . round($newSize/1024) . "KB (" . 
             round(100-$newSize/$size*100) . "% reduction)\n";
    } catch (Exception $e) {
        echo "ERROR: " . $e->getMessage() . "\n";
    }
}

echo "\nOptimization complete!\n";
echo "Processed files: $processed\n";
echo "Total space saved: " . round($totalSavings/1024) . "KB\n";
?>