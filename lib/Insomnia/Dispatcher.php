<?php

namespace Insomnia;

use \Doctrine\Common\ClassLoader,
    \Insomnia\Router\Route,
    \Insomnia\Controller\PluginInterface,
    \Insomnia\Registry;

class Dispatcher
{    
    public function dispatch( Route $route )
    {
        $request        = Registry::get( 'request' );
        $actionName     = $route->getAction( $request->getMethod() );

        if( false === $actionName )
            throw new DispatcherMethodException( 'Unsupported Method ' . $request->getMethod() . ' on ' . $request->getParam( 'path' ) );

        $matches        = $route->getMatches();
        $controllerName = \strtolower( $matches[ 'controller' ] );
        $actionName     = \strtolower( $actionName );

        $class = \Insomnia\Registry::get( 'controller_namespace' ) .
                 \ucfirst( $controllerName ) . '\\' . \ucfirst( $actionName ) .
                 \Insomnia\Registry::get( 'action_suffix' );

        if( !ClassLoader::classExists( $class ) )
            throw new DispatcherControllerException( 'Failed to dispatch request' );

        Registry::get( 'request' )->mergeParams( $matches );

        $action = new $class;
        $action->validate();
        $action->action();
        $action->getResponse()->prepare( $controllerName, $actionName );
        $action->render();
        $action->getResponse()->render();
    }
}

class DispatcherControllerException extends \Exception {};
class DispatcherMethodException extends \Exception {};