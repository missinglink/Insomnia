<?php

namespace Insomnia\Response\Plugin;

use \Insomnia\Pattern\Observer;
use \Insomnia\Response\Code;
use \Insomnia\Registry;
use \Insomnia\Response\Renderer\ViewRenderer;

class ResponseCodeSelector extends Observer
{
    /* @var $response \Insomnia\Response */
    public function update( \SplSubject $response )
    {
        if( null === $response->getCode() )
        {
            $renderer = $response->getRenderer();
            
            if( empty( $response ) && !( \is_object( $renderer ) && $renderer instanceof ViewRenderer ) )
                $response->setCode( Code::HTTP_NO_CONTENT );

            elseif( Registry::get( 'request' )->getMethod() === 'POST' )
                $response->setCode( Code::HTTP_CREATED );

            else $response->setCode( Code::HTTP_OK );
        }
    }
}