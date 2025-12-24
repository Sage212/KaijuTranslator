<?php

namespace KaijuTranslator\Builder;

class SitemapGen
{
    protected $savePath;
    protected $baseUrl;

    public function __construct($savePath, $baseUrl)
    {
        $this->savePath = rtrim($savePath, '/');
        $this->baseUrl = rtrim($baseUrl, '/');
        if (!is_dir($this->savePath)) {
            mkdir($this->savePath, 0755, true);
        }
    }

    public function generate($lang, $files)
    {
        $filename = 'sitemap-' . $lang . '.xml';
        $content = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $content .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml">' . "\n";

        foreach ($files as $file) {
            // $file is relative source path e.g. 'about.php'
            // If base lang, URL is /about.php
            // If other lang, URL is /en/about.php
            // Wait, logic needs to be precise.

            // Assume $files contains SOURCE paths.
            // Caller handles lang logic, or we do it here.
            // Let's assume we generate sitemap strictly for this lang.

            if ($lang === kaiju_config('base_lang')) {
                $url = $this->baseUrl . '/' . ltrim($file, '/');
            } else {
                $url = $this->baseUrl . '/' . $lang . '/' . ltrim($file, '/');
            }

            $content .= "  <url>\n";
            $content .= "    <loc>$url</loc>\n";
            // Optional: lastmod, changefreq
            $content .= "  </url>\n";
        }

        $content .= '</urlset>';
        file_put_contents($this->savePath . '/' . $filename, $content);
        return $filename;
    }

    public function generateIndex($sitemaps)
    {
        $filename = 'sitemap-index.xml';
        $content = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $content .= '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

        foreach ($sitemaps as $sitemap) {
            $url = $this->baseUrl . '/sitemaps/kaiju/' . $sitemap; // Assuming public URL structure matches file structure relative to root? 
            // Actually config says 'sitemaps_path' is where we SAVE.
            // We need a 'sitemaps_url' config or assume relative to domain root.
            // Let's assume standard /sitemaps/kaiju/ URL structure.

            $content .= "  <sitemap>\n";
            $content .= "    <loc>$url</loc>\n";
            $content .= "  </sitemap>\n";
        }

        $content .= '</sitemapindex>';
        file_put_contents($this->savePath . '/' . $filename, $content);
    }
}
