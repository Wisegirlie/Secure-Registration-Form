<?php

$libDir = realpath(__DIR__ . '/../libraries/libphonenumber/src');
if (!$libDir) {
    throw new Exception('Library directory not found at: ' . __DIR__ . '/../libraries/libphonenumber/src');
}

define('LIBPHONENUMBER_DIR', $libDir . '/');

spl_autoload_register(function ($class) {
    if (strpos($class, 'libphonenumber\\') === 0) {
        $file = LIBPHONENUMBER_DIR . str_replace('\\', '/', substr($class, 15)) . '.php';
        if (file_exists($file)) {
            require $file;
        } else {
            error_log("Libphonenumber file not found: " . $file);
            throw new Exception("Libphonenumber file not found: " . $file);
        }
    }
});


?>