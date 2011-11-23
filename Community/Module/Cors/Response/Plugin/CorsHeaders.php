<?php

namespace Community\Module\Cors\Response\Plugin;

use \Insomnia\Pattern\Observer;

class CorsHeaders extends Observer
{
    /* @var $response \Insomnia\Response */
    public function update( \SplSubject $response )
    {
        // Cross Origin Resource Sharing (CORS) Headers
        $response->setHeader( 'Access-Control-Allow-Origin', '*' );
        $response->setHeader( 'Access-Control-Allow-Methods', 'GET, PUT, POST, DELETE, TRACE, STATUS, OPTIONS' );
        $response->setHeader( 'Access-Control-Allow-Headers', 'X-Requested-With' );

        if( ( $ttl = $response->getTimeToLive() ) > 0 )
            $response->setHeader( 'Access-Control-Max-Age', $ttl );
    }
}