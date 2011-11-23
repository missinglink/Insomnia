<?php

namespace Insomnia\Kernel\Module\HTTP\Request\Plugin;

use \Insomnia\Pattern\Observer;

/**
 * Merge request headers in to the Insomnia request object.
 */
class HeaderParser extends Observer
{
    /* @var $request \Insomnia\Request */
    public function update( \SplSubject $request )
    {
        foreach( $_SERVER as $headerKey => $headerValue )
        {
            if( preg_match( '%^(?:HTTP_|REQUEST_)(?<key>\w+)$%', $headerKey, $matches ) )
            {
                // Format Key
                $headerKey = strtr( ucwords( strtolower( strtr( $matches[ 'key' ], '_', ' ' ) ) ), ' ', '-' );

                // Set Header
                $request->setHeader( $headerKey, $headerValue );
            }
    
        }
    }
}