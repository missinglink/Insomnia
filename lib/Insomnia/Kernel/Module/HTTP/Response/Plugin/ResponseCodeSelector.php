<?php

namespace Insomnia\Kernel\Module\HTTP\Response\Plugin;

use \Insomnia\Pattern\Observer;
use \Insomnia\Response\Code;
use \Insomnia\Registry;
//use \Insomnia\Kernel\Module\Mime\Response\Renderer\ViewRenderer;

class ResponseCodeSelector extends Observer
{
    /* @var $response \Insomnia\Response */
    public function update( \SplSubject $response )
    {
        if( null === $response->getCode() )
        {
//            $renderer = $response->getRenderer();

            // This code was commented out because it has a coupling to the Mime Component
//            if( empty( $response ) && !( \is_object( $renderer ) && $renderer instanceof ViewRenderer ) )
//                $response->setCode( Code::HTTP_NO_CONTENT );

            if( Registry::get( 'request' )->getMethod() === 'PUT' )
                $response->setCode( Code::HTTP_CREATED );

            else $response->setCode( Code::HTTP_OK );
        }
    }
}