<?php

namespace Insomnia\Kernel\Module\HTTP\Response\Plugin;

use \Insomnia\Pattern\Observer;

class CacheHeaders extends Observer
{
    /* @var $response \Insomnia\Response */
    public function update( \SplSubject $response )
    {
        $response->setHeader( 'Last-Modified', gmdate( 'D, d M Y H:i:s' ) . ' GMT' );

        // Set caching time for response
        if( ( $ttl = $response->getTimeToLive() ) > 0 )
        {
            $response->setHeader( 'Expires', gmdate( 'D, d M Y H:i:s', strtotime( "+{$ttl} secs" ) ) . ' GMT' );
            $response->setHeader( 'Cache-Control', "max-age={$ttl}, public" );
        }

        // Disable caching of response
        else
        {
            $response->setHeader( 'Expires', 'Sat, 22 Jan 1983 05:00:00 GMT' );
            $response->setHeader( 'Cache-Control', 'no-store, no-cache, no-transform, must-revalidate, post-check=0, pre-check=0' );
            $response->setHeader( 'Pragma', 'no-cache' );
        }
    }
}