<?php

namespace Insomnia\Kernel\Module\Mime\Response\Renderer;

use \Insomnia\Response\ResponseInterface,
    \Insomnia\Response,
    \Insomnia\Registry;

use \Insomnia\Response\ResponseAbstract;

class JsonRenderer extends ResponseAbstract implements ResponseInterface
{
    private $requestKey;
    
    public function __construct( $callback = '_jsonp' )
    {
        $this->setRequestKey( $callback );
    }
    
    public function render()
    {
        $jsonpCallback = $this->getRequestKey();
        
        if( null !== $jsonpCallback && Registry::get( 'request' )->hasParam( $jsonpCallback ) )
        {
            echo Registry::get( 'request' )->getParam( $jsonpCallback );
            echo '(' . \json_encode( $this->getResponse()->toArray() ) . ')';
        }

        else echo \json_encode( $this->getResponse()->toArray() );
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