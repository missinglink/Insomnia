<?php

namespace Insomnia;

use \Doctrine\Common\ClassLoader,
    \Insomnia\Router\Route,
    \Insomnia\Controller\PluginInterface,
    \Insomnia\Registry;

class DispatcherControllerException extends \Exception {};
class DispatcherMethodException extends \Exception {};

class Dispatcher
{
    public static $actionClassSuffix   = 'Action';
    
    private $controllerName,
            $actionName;

    public function dispatch( Route $route )
    {
        $request = Registry::get( 'request' );
        $macthes = $route->getMatches();

        $this->actionName = $route->getAction( $request->getMethod() );
        if( !$this->actionName ) throw new DispatcherMethodException( 'Unsupported Method ' . $request->getMethod() . ' on ' . $request->getPath() );

        $this->actionName       = \strtolower( $this->actionName );
        $this->controllerName   = \strtolower( $macthes[ 'controller' ] );

        $this->run( $route );
    }

    private function run( Route $route )
    {
        $class = \Insomnia\Registry::get( 'controller_namespace' ) .
                 \ucfirst( $this->controllerName ) . '\\' .
                 \ucfirst( $this->actionName ) .
                 self::$actionClassSuffix;

        if( !ClassLoader::classExists( $class ) )
            throw new DispatcherControllerException( 'Controller not found: ' . $this->controllerName );

        $controller = new $class();
        Registry::get( 'request' )->merge( $route->getMatches() );
        
        if( \method_exists( $controller, 'validate' ) )
            $controller->validate();

        if( \method_exists( $controller, 'action' ) )
            $controller->action();

        $controller->getResponse()->prepare( $this->controllerName, $this->actionName );

        if( \method_exists( $controller, 'render' ) )
            $controller->render();

        $controller->getResponse()->render();
        exit;
    }
}