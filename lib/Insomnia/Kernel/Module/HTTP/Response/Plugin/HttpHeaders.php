<?php

namespace Insomnia\Kernel\Module\HTTP\Response\Plugin;

use \Insomnia\Pattern\Observer;

/**
 * Set the header containing the response code.
 * With CGI, we also respond with the HTTP protocol version.
 *
 * FastCGI and CGI have different behaviour for this header.
 *
 * @link http://php.net/manual/en/function.header.php
 */
class HttpHeaders extends Observer
{
    /* @var $response \Insomnia\Response */
    public function update( \SplSubject $response )
    {
//        switch( isset( $_SERVER[ 'FCGI_ROLE' ] ) )
//        {
//            // FastCGI
//            case true :
//                header( 'Status: ' . $response->getCode(), true );
//                break;
//
//            // CGI
//            default :
                $protocol = isset( $_SERVER[ 'SERVER_PROTOCOL' ] )
                    ? $_SERVER[ 'SERVER_PROTOCOL' ]
                    : 'HTTP/1.1';
                
                header( $protocol . ' ' . $response->getCode(), true );
//        }
    }
}