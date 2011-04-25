<?php

namespace Insomnia;

use \Doctrine\Common\ClassLoader,
    \Insomnia\Router\Route;

class Dispatcher
{
    private $controllerNamespace = 'Application\Controller\\',
            $controllerSuffix    = 'Controller';

    public function dispatch( Request $request, Route $route )
    {
        $controllerName = strtolower( $route[ 'controller' ] );
        $class = $this->controllerNamespace . \ucfirst( $controllerName ) . $this->controllerSuffix;

        if( !ClassLoader::classExists( $class ) )
            throw new DispatcherException( 'Controller not found: ' . $class );

        $action = $route->getAction( $request->getMethod() );
        $controller = new $class();

        if( \method_exists( $controller, $action ) )
        {
            $request->merge( $route );
            
            $controller->setRequest( $request );
            $response = $controller->{ $action }();
            $controller->preRender( $controllerName, $action );
            $response->render();
            exit;
        }

        throw new DispatcherException( 'Unsupported Method' );
    }
}

class DispatcherException extends \Exception {};