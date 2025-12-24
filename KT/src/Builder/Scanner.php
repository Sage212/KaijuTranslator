<?php

namespace KaijuTranslator\Builder;

class Scanner
{
    protected $allowedPaths;
    protected $excludedPaths;
    protected $rootDir;

    public function __construct($allowedPaths, $excludedPaths, $rootDir)
    {
        $this->allowedPaths = $allowedPaths;

        // Strictly exclude internal KT folders and language folders
        $configLangs = function_exists('kaiju_config') ? kaiju_config('languages', []) : [];
        $this->excludedPaths = array_merge($excludedPaths, $configLangs, ['KT', 'setup.php', 'uninstall.php', 'README.md', '.gitignore', 'sitemaps', 'tests']);

        $this->rootDir = $this->normalizePath(realpath($rootDir));
    }

    protected function normalizePath($path)
    {
        return str_replace('\\', '/', $path);
    }

    public function scan()
    {
        $files = [];
        foreach ($this->allowedPaths as $path) {
            $path = $this->normalizePath(realpath($path));
            if (is_dir($path)) {
                $files = array_merge($files, $this->scanDir($path));
            }
        }
        return array_unique($files);
    }

    protected function scanDir($dir)
    {
        $results = [];
        $items = scandir($dir);

        foreach ($items as $item) {
            if ($item === '.' || $item === '..')
                continue;

            $fullPath = $dir . '/' . $item;
            // $dir is already normalized if recursive, or from allowedPaths
            // But we need to ensure consistency

            $relativePath = str_replace($this->rootDir . '/', '', $fullPath);

            // Check exclusions
            if ($this->isExcluded($relativePath)) {
                continue;
            }

            if (is_dir($fullPath)) {
                $results = array_merge($results, $this->scanDir($fullPath));
            } elseif (pathinfo($fullPath, PATHINFO_EXTENSION) === 'php') {
                $results[] = $relativePath;
            }
        }
        return $results;
    }

    protected function isExcluded($path)
    {
        foreach ($this->excludedPaths as $excluded) {
            // Simple logic: if path starts with excluded folder or contains it
            if (strpos($path, $excluded) === 0 || strpos($path, '/' . $excluded) !== false) {
                return true;
            }
        }
        return false;
    }
}
