<?php

namespace Insomnia\Kernel\Module\HTTP\Request\Plugin;

use \Insomnia\Pattern\Observer;

class BodyParser extends Observer
{
    /* @var $request \Insomnia\Request */
    public function update( \SplSubject $request )
    {
        if( isset( $_SERVER['REQUEST_METHOD'] ) )
        {
            switch( strtoupper( $_SERVER['REQUEST_METHOD'] ) )
            {
                case 'PUT': case 'DELETE':

                    $body = trim( file_get_contents( 'php://input' ) );
                    $request->setBody( $body );

                    if( strlen( $body ) )
                    {
                        switch( $request->getContentType() )
                        {
                            case 'application/x-www-form-urlencoded' :
                            default :
                                parse_str( $body, $params );
                                $request->mergeParams( array_filter( $params ) );
                        }
                    }
            }
        }
    }
}