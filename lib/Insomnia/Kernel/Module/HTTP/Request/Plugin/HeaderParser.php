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
            if( preg_match( '/^(?:HTTP_|REQUEST_)(?<key>\w+)$/D', $headerKey, $matches ) )
            {
                // Set Header
                $request->setHeader( $this->normalizeHeaderKey( $matches[ 'key' ] ), $headerValue );
                
                continue;
            }
            
            else if( 0 === strpos( $headerKey, 'CONTENT_' ) )
            {
                // Set Header
                $request->setHeader( $this->normalizeHeaderKey( $headerKey ), $headerValue );
                
                continue;
            }
        }
    }
    
    private function normalizeHeaderKey( $key )
    {
        // Format Key
        return strtr( ucwords( strtolower( strtr( $key, '_', ' ' ) ) ), ' ', '-' );
    }
}