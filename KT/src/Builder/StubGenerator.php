<?php

namespace KaijuTranslator\Builder;

class StubGenerator
{
    protected $rootDir;

    public function __construct($rootDir)
    {
        $this->rootDir = rtrim($rootDir, '/');
    }

    public function createStubs(array $files, array $languages)
    {
        $created = 0;
        foreach ($languages as $lang) {
            $langDir = $this->rootDir . '/' . $lang;
            if (!is_dir($langDir)) {
                mkdir($langDir, 0755, true);
            }

            foreach ($files as $file) {
                // $file is relative path like 'about.php' or 'contact/index.php'
                $destPath = $langDir . '/' . $file;
                $destDir = dirname($destPath);

                if (!is_dir($destDir)) {
                    mkdir($destDir, 0755, true);
                }

                $this->writeStub($destPath, $lang);
                $created++;
            }
        }
        return $created;
    }

    protected function writeStub($path, $lang)
    {
        // We need a relative path to the centralized runner
        // If path is /en/about.php, runner is at ../kaiju-translator/run.php
        // Count depth
        $depth = substr_count($path, '/') - substr_count($this->rootDir, '/');
        // Actually, $path is absolute here.

        $relativePathToRoot = str_repeat('../', substr_count(str_replace($this->rootDir . '/', '', $path), '/'));

        $content = "<?php\n";
        $content .= "define('KT_LANG', '$lang');\n";
        $content .= "require __DIR__ . '/{$relativePathToRoot}KT/run.php';\n";

        file_put_contents($path, $content);
    }
}
