<?php

namespace KaijuTranslator\Processing;

class HtmlInjector
{

    public function injectSeo($html, $lang, $translationsMap, $currentPath)
    {
        // translationsMap is array of [lang => url] for hreflang

        $headEnd = strpos($html, '</head>');
        if ($headEnd === false) {
            return $html;
        }

        $tags = '';
        foreach ($translationsMap as $l => $url) {
            $tags .= '<link rel="alternate" hreflang="' . $l . '" href="' . $url . '" />' . "\n";
        }

        // Add canonical if not present (simple check)
        // If 'self' strategy:
        // $tags .= '<link rel="canonical" href="' . $translationsMap[$lang] . '" />' . "\n";

        return substr_replace($html, $tags, $headEnd, 0);
    }
}
