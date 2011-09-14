<?php

namespace Insomnia\Kernel\Module\Mime\Dispatcher\Plugin;

use \Insomnia\Pattern\Observer;
use \Insomnia\Annotation\Parser\ViewParser;

class ViewAnnotationReader extends Observer
{
    /* @var $request \Insomnia\EndPoint */
    public function update( \SplSubject $endpoint )
    {
        //-- Get view file location from annotations 
        $viewAnnotation = new ViewParser( $endpoint->getMethodAnnotations() );
        if( isset( $viewAnnotation[ 'value' ] ) )
            $endpoint->getController()->getResponse()->setView( $viewAnnotation['value'] );
    }
}