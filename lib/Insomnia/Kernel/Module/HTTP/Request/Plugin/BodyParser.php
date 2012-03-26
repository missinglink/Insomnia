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
            $body = trim( file_get_contents( 'php://input' ) );
            
            $request->setBody( $body );

            if( strlen( $body ) )
            {
                switch( $request->getContentType() )
                {
                    case 'application/json' :
                        $request->mergeParams( json_decode( $body ) );
                        break;

                    case 'application/x-www-form-urlencoded' :
                    default :
                        
                        // Hack to avoid parsing json & XML
                        if( strpos( $body, '=' ) && !in_array( substr( $body, 0, 1 ), array( '<', '{' ) ) )
                        {
                            parse_str( $body, $params );

                            $request->mergeParams( array_filter( $params, function($value) {
                                return $value !== '';
                            }));   
                        }
                }
            }
        }
    }
}