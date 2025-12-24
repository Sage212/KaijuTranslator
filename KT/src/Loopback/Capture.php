<?php

namespace KaijuTranslator\Loopback;

class Capture
{

    public function fetch($url)
    {
        // Prefer curl for better control
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

        // CRITICAL: Prevent loops.
        // We set a custom header that the base site's Widget MUST detect to avoid trying to translate logic again?
        // Actually, strictly speaking, if we request the BASE url (e.g. /about.php), 
        // and /about.php does NOT redirect to /en/, we are safe.
        // But if /about.php has auto-redirect logic, we need to bypass it.
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'X-Kaiju-Loopback: true',
            'User-Agent: KaijuTranslator/1.0'
        ]);

        // Forward cookies if strictly necessary? Spec says "no user specific content".
        // So we strip cookies to ensure we get the "public" version of the page.
        curl_setopt($ch, CURLOPT_COOKIE, '');

        $html = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode !== 200 || !$html) {
            return false; // Return false or throw exception
        }

        return $html;
    }
}
