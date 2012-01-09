<?php

namespace Community\Module\Testing\Transport\Browser;

use \Community\Module\Testing\Transport\HTTPRequest;

class Firefox_v8_0 extends HTTPRequest
{
    public function getHeaders()
    {
        return array(
            'User-Agent' => 'Mozilla/5.0 (Ubuntu; X11; Linux x86_64; rv:8.0) Gecko/20100101 Firefox/8.0',
            'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
            'Accept-Encoding' => 'gzip, deflate',
            'Accept-Language' => 'en-us,en;q=0.5',
            'Accept-Charset' => 'ISO-8859-1,utf-8;q=0.7,*;q=0.7',
            'Connection' => 'keep-alive',
            'Time' => time()
        );
    }
}