<?php
echo "<pre>";
echo "Starting Cache Reset...\n\n";

/* -----------------------------
   Clear PHP OPcache
----------------------------- */
if (function_exists('opcache_reset')) {
    opcache_reset();
    echo "[OK] OPcache cleared\n";
} else {
    echo "[!] OPcache not enabled\n";
}

/* -----------------------------
   Clear APCu Cache
----------------------------- */
if (function_exists('apcu_clear_cache')) {
    apcu_clear_cache();
    echo "[OK] APCu cache cleared\n";
}

/* -----------------------------
   Clear System Temp Directory
----------------------------- */
function clearDir($dir) {
    if (!is_dir($dir)) return;

    $files = scandir($dir);
    foreach ($files as $file) {
        if ($file == '.' || $file == '..') continue;

        $path = $dir . '/' . $file;

        if (is_dir($path)) {
            clearDir($path);
            @rmdir($path);
        } else {
            @unlink($path);
        }
    }
}

/* Common cache folders */
$cache_dirs = [
    'cache',
    'tmp',
    'temp',
    '../cache',
    '../tmp'
];

foreach ($cache_dirs as $dir) {
    clearDir($dir);
    echo "[OK] Cleared: $dir\n";
}

echo "\nCache Reset Completed ✅";
echo "</pre>";
?>