<?php

namespace KaijuTranslator\Builder;

class StubGenerator
{
    protected $rootDir;

    public function __construct($rootDir)
    {
        $this->rootDir = str_replace('\\', '/', realpath($rootDir));
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
        // Normalize paths for comparison
        $path = str_replace('\\', '/', $path);

        // Calculate relative path from the stub to the KT directory
        $relativeFromRoot = str_replace($this->rootDir . '/', '', $path);
        $depth = substr_count($relativeFromRoot, '/');

        $relativePathToRoot = str_repeat('../', $depth);

        $content = "<?php\n";
        $content .= "define('KT_LANG', '$lang');\n";
        $content .= "require __DIR__ . '/{$relativePathToRoot}KT/run.php';\n";

        file_put_contents($path, $content);
    }
}
