<?php

namespace Community\Module\Testing\Transport\Browser;

use \Community\Module\Testing\Transport\HTTPRequest;

/**
 * @version Blackberry 6
 */
class BlackBerry extends HTTPRequest
{
    public function getHeaders()
    {
        return array(
            'User-Agent' => 'Mozilla/5.0 (BlackBerry; U; BlackBerry <model>; en-US) AppleWebKit/<webkit_version> (KHTML, like Gecko) Version/<version> Mobile Safari/<webkit_version>',
            'Accept' => 'text/html,application/xhtml+xml,application/xml,application/x-javascript,*/*;q=0.5',
            'x-wap-profile' => 'http://www.blackberry.net/go/mobile/profiles/uaprof/<BlackBerry-model>_<network-bearer>/<software-version>.rdf',
        );
    }
}