<?php

use KaijuTranslator\Processing\HtmlInjector;

run_test('HtmlInjector::injectSeo (Hreflang)', function () {
    $injector = new HtmlInjector();

    $html = '<html><head><title>Test</title></head><body></body></html>';
    $lang = 'en';
    $map = [
        'es' => 'http://site.com/about.php',
        'en' => 'http://site.com/en/about.php'
    ];

    $result = $injector->injectSeo($html, $lang, $map, '/about.php');

    // Check if link tags exist
    assert_true(strpos($result, 'hreflang="es"') !== false, "Missing hreflang es");
    assert_true(strpos($result, 'hreflang="en"') !== false, "Missing hreflang en");

    return true;
});
