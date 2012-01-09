<?php

namespace Community\Module\Testing\Transport\Browser;

use \Community\Module\Testing\Transport\HTTPRequest;

class Curl_v7_21 extends HTTPRequest
{
    public function getHeaders()
    {
        return array(
            'User-Agent' => 'curl/7.21.0 (x86_64-pc-linux-gnu) libcurl/7.21.0 OpenSSL/0.9.8o zlib/1.2.3.4 libidn/1.18',
            'Accept' => '*/*'
        );
    }
}