<?php
// Since build runs in CLI, REQUEST_URI is not available.
// We need to guess or config the base URL.
// For now, let's assume localhost or config.

function get_cli_base_url()
{
    // In production, this should be in config.
    // For local dev on desktop, maybe http://localhost/Kaijutranslator
    return 'http://localhost/Kaijutranslator';
}
