<?php

namespace Insomnia\Request;

use \Insomnia\Pattern\Observer;

class HeaderParser extends Observer
{
    /* @var $request \Insomnia\Request */
    public function update( \SplSubject $request )
    {
        $this->addHeaders( $request, $_SERVER, 'HTTP_' );
        $this->addHeaders( $request, $_SERVER, 'REQUEST_' );
        $request->setMethod( $_SERVER['REQUEST_METHOD'] );
    }

    private function addHeaders( $request, $headers, $match = false )
    {
        $matchLength = \is_string( $match ) ? \strlen( $match ) : false;

        foreach( $headers as $k => $v )
        {
            if( false !== $matchLength )
            {
                if( \strncmp( $k, $match, $matchLength ) ) continue;
                else $k = \substr( $k, $matchLength );
            }

            /* Format Key */
            $k = \strtr( \ucwords( \strtolower( \strtr( $k, '_', ' ' ) ) ), ' ', '-' );

            $request->setHeader( $k, $v );
        }
    }
}