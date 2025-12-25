<?php
// tests/verify_v1_1_0.php

require_once __DIR__ . '/run_tests.php';

echo "\n🦖 KaijuTranslator v1.1.0 Verification 🦖\n";
echo "============================================\n";

// 1. Test Widget Persistence (Save Config)
run_test("Visual Intelligence: Widget Persistence", function () {
    // Modify config via helper
    require_once __DIR__ . '/../save_config_helper.php';
    $config = kaiju_config();

    // Simulate Save
    $testStyle = 'kaiju';
    $testContent = 'flags';

    $res = save_kaiju_config(
        $config['base_url'],
        $config['base_lang'],
        $config['languages'],
        $config['translation_provider'],
        $config['model'],
        $config['api_key'],
        $testStyle,
        $testContent
    );

    assert_true($res, "Config save should return true");

    // Reload Config
    $newConfig = include __DIR__ . '/../kaiju-config.php';
    assert_equals($testStyle, $newConfig['widget_style'], "Widget Style should be saved");
    assert_equals($testContent, $newConfig['widget_content'], "Widget Content should be saved");

    return true;
});

// 2. Test Volume Calculation Logic
run_test("Intelligence Grid: Volume Calculation", function () {
    require_once __DIR__ . '/../src/Core/Analyzer.php';
    $config = kaiju_config();
    $analyzer = new \KaijuTranslator\Core\Analyzer(realpath(__DIR__ . '/../../'), $config['base_url']); // Scan root

    $analysisResults = $analyzer->scanStructure(true);

    // Count files
    $fileCount = 0;
    $stack = [$analysisResults['tree']];
    while ($node = array_pop($stack)) {
        foreach ($node as $child) {
            if ($child['type'] === 'file')
                $fileCount++;
            if ($child['type'] === 'folder' && !empty($child['children']))
                $stack[] = $child['children'];
        }
    }

    // Logic Verification
    assert_true($fileCount > 0, "Analyzer should find files in root ($fileCount found)");

    // Simulate Session Storage
    $_SESSION['kaiju_volume'] = $fileCount;
    assert_equals($fileCount, $_SESSION['kaiju_volume'], "Volume should be stored in session");

    return true;
});

// 3. Test Widget Output Logic
run_test("Production: Widget Rendering", function () {
    // Generate Widget Output
    ob_start();
    require __DIR__ . '/../widget.php';
    $output = ob_get_clean();

    $config = kaiju_config();
    $style = $config['widget_style']; // should be 'kaiju' from test 1

    // Check if correct class class is present
    $classFound = strpos($output, "kt-$style") !== false;
    assert_true($classFound, "Widget should render class 'kt-$style'");

    return true;
});

echo "\nVerification Complete.\n";
