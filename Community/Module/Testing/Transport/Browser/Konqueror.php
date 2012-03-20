<?php

namespace Community\Module\Testing\Transport\Browser;

use \Community\Module\Testing\Transport\HTTPRequest;

/**
 * @version Konqueror 4.5.5
 */
class Konqueror extends HTTPRequest
{
    public function getHeaders()
    {
        return array(
            'Connection' => 'keep-alive',
            'User-Agent' => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/535.1 (KHTML, like Gecko) Ubuntu/10.10 Chromium/14.0.835.202 Chrome/14.0.835.202 Safari/535.1',
            'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
            'Accept-Encoding' => 'gzip,deflate,sdch',
            'Accept-Language' => 'en-GB,en-US;q=0.8,en;q=0.6',
            'Accept-Charset' => 'ISO-8859-1,utf-8;q=0.7,*;q=0.3',
            'Time' => time()
        );
    }
}