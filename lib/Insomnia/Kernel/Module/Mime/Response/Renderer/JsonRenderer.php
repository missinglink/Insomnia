<?php

namespace Insomnia\Kernel\Module\Mime\Response\Renderer;

use \Insomnia\Response\ResponseInterface,
    \Insomnia\Response,
    \Insomnia\Registry;

class JsonRenderer implements ResponseInterface
{
    private $requestKey;
    
    public function __construct( $callback = '_jsonp' )
    {
        $this->setRequestKey( $callback );
    }
    
    public function render( Response $response )
    {
        $jsonpCallback = $this->getRequestKey();
        
        if( null !== $jsonpCallback && Registry::get( 'request' )->hasParam( $jsonpCallback ) )
        {
            echo Registry::get( 'request' )->getParam( $jsonpCallback );
            echo '(' . \json_encode( $response->toArray() ) . ')';
        }

        else echo \json_encode( $response->toArray() );
    }
    
    public function getRequestKey()
    {
        return $this->requestKey;
    }

    public function setRequestKey( $requestKey )
    {
        $this->requestKey = $requestKey;
    }
}