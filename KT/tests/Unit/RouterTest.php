<?php

use KaijuTranslator\Core\Router;

run_test('Router::resolveSourceUrl (Basic)', function () {
    $config = ['base_lang' => 'es'];
    $router = new Router($config);

    // Mock Server request
    $_SERVER['REQUEST_URI'] = '/en/about.php';

    // Test logic manually since we can't easily injection mock $_SERVER into class without modifying it
    // But our Router reads $_SERVER directly in current implementation.
    // Ideally we should refactor Router to accept URI in method, but let's just create a new instance method for testing or simply subclass.

    // Refactored logic check:
    // $router->resolveSourceUrl('en') should return /about.php given current URI /en/about.php

    $source = $router->resolveSourceUrl('en');

    return assert_equals('/about.php', $source);
});
