<?php

namespace KaijuTranslator\Core;

class Cache
{
    protected $cachePath;

    public function __construct($path)
    {
        $this->cachePath = rtrim($path, '/');
        if (!is_dir($this->cachePath)) {
            @mkdir($this->cachePath, 0777, true);
        }
    }

    public function get($key)
    {
        $file = $this->getFilePath($key);
        if (file_exists($file)) {
            // Check TTL if needed, for now assumes valid until invalidated
            return file_get_contents($file);
        }
        return null;
    }

    public function set($key, $content)
    {
        $file = $this->getFilePath($key);
        return file_put_contents($file, $content);
    }

    protected function getFilePath($key)
    {
        // Sanitize key locally, usually it's a hash
        return $this->cachePath . '/' . $key . '.html';
    }

    public function generateKey($url, $lang, $contentHash = '')
    {
        return md5($url . '|' . $lang . '|' . $contentHash);
    }
}
