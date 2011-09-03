<?php

namespace Insomnia\Dispatcher\Plugin;

use \Insomnia\Registry,
    \Insomnia\Pattern\Observer,
    \Insomnia\Annotation\Parser\ParamParser;

class DocumentationEndPoint extends Observer
{
    /* @var $endpoint \Insomnia\Dispatcher\EndPoint */
    public function update( \SplSubject $endpoint )
    {
        if( Registry::get( 'request' )->hasParam( '_discover' ) &&
            $endpoint->getClass() !== Registry::get( 'error_endpoint' ) )
        {
            $response = $endpoint->getController()->getResponse();
            $response->set( 'uri', Registry::get( 'request' )->getUri() );
            $response->set( 'method', Registry::get( 'request' )->getMethod() );
            
            $endpoint->getController()->getResponse()->setView( 'status/discover' );
            
            $params = new ParamParser( $endpoint->getMethodAnnotations() );
            $response->set( 'params', $params->toArray() );
            $response->render();
        }
    }
}