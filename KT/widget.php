<?php
// Include this file in your website's header or footer
// Example: <?php include __DIR__ . '/KT/widget.php'; ?>

if (!defined('KAIJU_START')) {
require_once __DIR__ . '/bootstrap.php';
}

$config = kaiju_config();
$langs = $config['languages'];
$baseLang = $config['base_lang'];

// Determine current lang
$currentLang = defined('KT_LANG') ? KT_LANG : $baseLang;

// Determine source path
// If we are in a stub, Router logic might not be instantiated if we are just including the widget in the BASE page.
// We need to support both contexts.
if (class_exists('KaijuTranslator\Core\Router')) {
$router = new KaijuTranslator\Core\Router($config);
$sourcePath = $router->resolveSourceUrl($currentLang);
} else {
// Only happens if bootstrap failed or context weird, fallback
$sourcePath = $_SERVER['REQUEST_URI'];
}

echo '<div class="kaiju-widget"
    style="position: fixed; bottom: 20px; right: 20px; z-index: 9999; background: white; padding: 10px; border-radius: 5px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
    ';
    echo '<select onchange="window.location.href=this.value">';

        foreach ($langs as $lang) {
        if ($lang === $baseLang) {
        $url = $sourcePath;
        // Ensure we don't double slash if sourcePath is /
        if ($url === '/') $url = '/'; // Keep as /
        } else {
        $url = '/' . $lang . $sourcePath;
        }

        $selected = ($lang === $currentLang) ? 'selected' : '';
        echo '<option value="' . htmlspecialchars($url) . '" ' . $selected . '>' . strtoupper($lang) . '</option>';
        }

        echo '</select>';
    echo '</div>';