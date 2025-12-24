<?php

return [
    // 1. Language Configuration
    'base_lang' => 'es', // El idioma original del sitio
    'languages' => ['es', 'en', 'fr'], // Lista de idiomas habilitados
    
    // 2. Translation Provider
    'translation_provider' => 'deepseek', // 'deepseek', 'gpt4', etc.
    'api_key' => getenv('KAIJU_API_KEY') ?: '', // Mejor usar variables de entorno
    
    // 3. Operation Mode
    'mode' => 'on_demand', // 'on_demand' (genera al visitar) o 'prebuild' (solo manual)
    
    // 4. Discovery (Builder)
    'discovery_mode' => 'filesystem', // 'filesystem' o 'sitemap'
    'allowed_paths' => [
        __DIR__ . '/../', // Escanear desde la raíz del proyecto
    ],
    'excluded_paths' => [
        'kaiju-translator',
        'vendor',
        'node_modules',
        'cache',
        'admin',
        'login',
        '.git',
    ],
    
    // 5. Paths
    'cache_path' => __DIR__ . '/cache',
    'state_path' => __DIR__ . '/state',
    'sitemaps_path' => __DIR__ . '/../sitemaps/kaiju', 
    
    // 6. SEO
    'seo' => [
        'hreflang_enabled' => true,
        'canonical_strategy' => 'self', // 'self' apunta a la URL traducida
    ],
    
    // 7. QA
    'qa' => [
        'min_score' => 80,
        'policy_on_fail' => 'noindex', // 'fallback_base' o 'noindex'
    ],
];
