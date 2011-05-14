<?php

namespace Insomnia;

use \Doctrine\Common\ClassLoader,
    \Insomnia\Router\Route,
    \Insomnia\Controller\PluginInterface,
    \Insomnia\Registry;

class Dispatcher
{
    /* @var STRICT_CHECKING boolean Check if class is semantically valid */
    const STRICT_CHECKING = true;

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

        if( self::STRICT_CHECKING )
            new \ReflectionClass( $class );
        
        Registry::get( 'request' )->mergeParams( $matches );

        $action = new $class;
        if( !self::STRICT_CHECKING || \method_exists( $action, 'validate' ) ) $action->validate();
        if( !self::STRICT_CHECKING || \method_exists( $action, 'action' ) ) $action->action();
        $action->getResponse()->prepare( $controllerName, $actionName );
        if( !self::STRICT_CHECKING || \method_exists( $action, 'render' ) ) $action->render();
        $action->getResponse()->render();
    }
}

class DispatcherControllerException extends \Exception {};
class DispatcherMethodException extends \Exception {};