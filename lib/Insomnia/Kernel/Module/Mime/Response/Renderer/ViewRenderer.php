<?php

namespace Insomnia\Kernel\Module\Mime\Response\Renderer;

use \Insomnia\Response,
    \Insomnia\Annotation\Parser\ViewParser,
    \Insomnia\Annotation\Parser\LayoutParser;

use \Insomnia\Response\ResponseInterface,
    \Insomnia\Response\ResponseAbstract;

use \Doctrine\Common\ClassLoader;

class ViewRenderer extends ResponseAbstract implements ResponseInterface
{
    public function render()
    {
        /** @var $endpoint \Insomnia\Dispatcher\EndPoint */
        $endpoint = $this->getResponse()->getEndPoint();
        
        // View Annotations
        $viewAnnotation = new ViewParser( $endpoint->getMethodAnnotations() );
        $viewClass = $viewAnnotation->get( 'value' );
        
        // Validate View
        if( null == $viewClass || !ClassLoader::classExists( trim( $viewClass, '\\' ) ) )
        {
            throw new ViewException( 'View File Not Registered' );
        }
        
        // Layout Annotations
        $layoutAnnotation = new LayoutParser( $endpoint->getMethodAnnotations() );
        $layoutClass = $layoutAnnotation->get( 'value' );
        
        /** @var $view \Insomnia\Pattern\View */
        $view = new $viewClass;
        $view->setResponse( $this->getResponse() );
        $view->render();
        
        // With Layout
        if( null !== $layoutClass || ClassLoader::classExists( trim( $layoutClass, '\\' ) ) )
        {
            /** @var \Insomnia\Pattern\Layout $layout */
            $layout = new $layoutClass;
            $layout->setView( $view );
            $layout->render();
            echo $layout->getOutput();
        }
        
        // View Only
        else
        {           
            echo $view->getOutput();
        }
    }
}