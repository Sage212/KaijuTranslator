<?php

// Prevent direct access if needed, though this file is usually included
if (!defined('KAIJU_START')) {
    define('KAIJU_START', microtime(true));
}

// 1. Class Autoloader
spl_autoload_register(function ($class) {
    $prefix = 'KaijuTranslator\\';
    $base_dir = __DIR__ . '/src/';

    // Does the class use the namespace prefix?
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    // Get the relative class name
    $relative_class = substr($class, $len);

    // Replace the namespace prefix with the base directory, replace namespace
    // separators with directory separators in the relative class name, append
    // with .php
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

    // If the file exists, require it
    if (file_exists($file)) {
        require $file;
    }
});

// 2. Load Configuration
if (!function_exists('kaiju_config')) {
    function kaiju_config($key = null, $default = null)
    {
        static $config;
        if (!$config) {
            // Config is now inside KT/
            $userConfigFile = __DIR__ . '/kaiju-config.php';
            $internalConfigFile = __DIR__ . '/config.php';

            if (file_exists($userConfigFile)) {
                $config = require $userConfigFile;
            } elseif (file_exists($internalConfigFile)) {
                $config = require $internalConfigFile;
            } else {
                $config = [];
            }
        }

        if ($key === null) {
            return $config;
        }

        // Simple dot notation support (e.g., 'seo.hreflang_enabled')
        $keys = explode('.', $key);
        $value = $config;
        foreach ($keys as $k) {
            if (isset($value[$k])) {
                $value = $value[$k];
            } else {
                return $default;
            }
        }
        return $value;
    }
}
