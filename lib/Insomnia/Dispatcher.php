<?php

namespace Insomnia;

use \Doctrine\Common\ClassLoader,
    \Insomnia\Router\Route,
    \Insomnia\Controller\PluginInterface;

class DispatcherControllerException extends \Exception {};
class DispatcherMethodException extends \Exception {};

class Dispatcher
{
    public static $controllerNamespace = '',
                  $actionClassSuffix   = 'Action';
    
    private $controllerName,
            $actionName;

    public function dispatch( Request $request, Route $route )
    {
        $this->actionName = $route->getAction( $request->getMethod() );
        if( !$this->actionName ) throw new DispatcherMethodException( 'Unsupported Method ' . $request->getMethod() . ' on ' . $request->getPath() );

        $this->actionName       = \strtolower( $this->actionName );
        $this->controllerName   = \strtolower( $route[ 'controller' ] );

        $this->run( $request, $route );
    }

    private function run( Request $request, Route $route )
    {
        $class = self::$controllerNamespace .
                 \ucfirst( $this->controllerName ) . '\\' .
                 \ucfirst( $this->actionName ) .
                 self::$actionClassSuffix;

        if( !ClassLoader::classExists( $class ) )
            throw new DispatcherControllerException( 'Controller not found: ' . $this->controllerName );

        $controller = new $class();
        $request->merge( $route );
        
        $controller->setRequest( $request );
        
        if( \method_exists( $controller, 'validate' ) )
            $controller->validate();

        if( \method_exists( $controller, 'action' ) )
            $controller->action();

        $controller->getResponse()->prepare( $this->controllerName, $this->actionName, $request );

        if( \method_exists( $controller, 'render' ) )
            $controller->render();

        $controller->getResponse()->render();
        exit;
    }
}