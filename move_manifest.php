<?php

$buildDir     = __DIR__ . '/public/build';
$manifestPath = $buildDir . '/appl/manifest.json';
$parentDir    = dirname($buildDir);
$newPath      = $buildDir . '/manifest.json';

// Check if manifest file exists
if (! file_exists($manifestPath)) {
    die("Manifest file not found in {$manifestPath}");
}

// Read and parse manifest
$manifest = json_decode(file_get_contents($manifestPath), true);
if (json_last_error() !== JSON_ERROR_NONE) {
    die("Error parsing manifest.json: " . json_last_error_msg());
}

// Modify asset paths
foreach ($manifest as $key => &$value) {
    if (isset($value['file']) && strpos($value['file'], 'assets/') === 0) {
        $value['file'] = 'appl/' . $value['file'];
    }

    // Handle CSS imports
    if (isset($value['css'])) {
        foreach ($value['css'] as &$cssPath) {
            if (strpos($cssPath, 'assets/') === 0) {
                $cssPath = 'appl/' . $cssPath;
            }
        }
    }
}

// Save modified manifest to parent directory
if (! file_put_contents($newPath, json_encode($manifest, JSON_UNESCAPED_SLASHES))) {
    die("Failed to write manifest file to {$newPath}");
}

// Remove original manifest file
if (! unlink($manifestPath)) {
    die("Failed to remove original manifest file: {$manifestPath}");
}

echo "Successfully moved and modified manifest.json to parent directory";
