<?php

namespace Insomnia\Request\Plugin;

use \Insomnia\Pattern\Observer;

class BodyParser extends Observer
{
    /* @var $request \Insomnia\Request */
    public function update( \SplSubject $request )
    {
        switch( \strtoupper( $_SERVER['REQUEST_METHOD'] ) )
        {
            case 'PUT': case 'POST':

                $body = \trim( \file_get_contents( 'php://input' ) );
                $request->setBody( $body );

                if( \strlen( $body ) )
                {
                    switch( $request->getContentType() )
                    {
                        case 'application/json' :
                            $json = \json_decode( $body, true );
                            if( null !== $json ) $request->mergeParams( $json );
                            break;

                        case 'application/x-www-form-urlencoded' :
                        default :
                            \parse_str( $body, $params );
                            $request->mergeParams( \array_filter( $params ) );
                    }
                }
        }
    }
}