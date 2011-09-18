<?php

namespace Insomnia\Kernel\Module\HTTP\Response\Plugin;

use \Insomnia\Pattern\Observer;

class HttpHeaders extends Observer
{
    /* @var $response \Insomnia\Response */
    public function update( \SplSubject $response )
    {
        $protocol = isset( $_SERVER[ 'SERVER_PROTOCOL' ] ) ? $_SERVER[ 'SERVER_PROTOCOL' ] : 'HTTP/1.1';
        
        \header( $protocol . ' ' . $response->getCode() );        
        \header( 'Content-Type: ' . $response->getContentType() . '; charset=\'' . $response->getCharacterSet() .'\'' );
    }
}