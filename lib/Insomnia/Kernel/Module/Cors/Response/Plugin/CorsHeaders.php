<?php

namespace Insomnia\Kernel\Module\Cors\Response\Plugin;

use \Insomnia\Pattern\Observer;

class CorsHeaders extends Observer
{
    /* @var $response \Insomnia\Response */
    public function update( \SplSubject $response )
    {
        // Cross Origin Resource Sharing (CORS) Headers
        \header( 'Access-Control-Allow-Origin: *' );
        \header( 'Access-Control-Allow-Methods: GET, PUT, POST, DELETE, TRACE, STATUS, OPTIONS' );
        \header( 'Access-Control-Allow-Headers: X-Requested-With' );

        if( ( $ttl = $response->getTimeToLive() ) > 0 )
            \header( 'Access-Control-Max-Age: ' . $ttl );
    }
}