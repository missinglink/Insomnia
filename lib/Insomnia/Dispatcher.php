<?php

namespace Insomnia;

use \Doctrine\Common\ClassLoader,
    \Insomnia\Router\Route,
    \Insomnia\Controller\PluginInterface;

class DispatcherControllerException extends \Exception {};
class DispatcherMethodException extends \Exception {};

class Dispatcher
{
    private $controllerNamespace  = 'Application\Controller\\',
            $controllerSuffix     = 'Controller',
            $validateMethodSuffix = 'Validate';

    public function dispatch( Request $request, Route $route )
    {
        $controllerName = strtolower( $route[ 'controller' ] );
        $class = $this->controllerNamespace . \ucfirst( $controllerName ) . $this->controllerSuffix;

        if( !ClassLoader::classExists( $class ) )
            throw new DispatcherControllerException( 'Controller not found: ' . $controllerName );

        $action = $route->getAction( $request->getMethod() );
        $controller = new $class();

        if( \method_exists( $controller, $action ) )
        {
            $request->merge( $route );
            
            $controller->setRequest( $request );
            $controller->preDispatch( $controllerName, $action );
            if( \method_exists( $controller, $action . $this->validateMethodSuffix ) ) $controller->{ $action . $this->validateMethodSuffix }();
            $controller->{ $action }();
            $controller->preRender( $controllerName, $action );
            $controller->getResponse()->render();
            exit;
        }

        throw new DispatcherMethodException( 'Unsupported Method ' . $request->getMethod() . ' on ' . $request->getPath() );
    }
}