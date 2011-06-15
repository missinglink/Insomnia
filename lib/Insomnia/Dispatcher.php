<?php

namespace Insomnia;

use \Doctrine\Common\ClassLoader,
    \Insomnia\Router\Route,
    \Insomnia\Controller\PluginInterface,
    \Insomnia\Registry,
    Insomnia\Validator\DatabaseException;

class Dispatcher
{
    /* @var STRICT_CHECKING boolean Check if class is semantically valid */
    const STRICT_CHECKING = true;

    private $controller;
    private $route;
    
    public function dispatch( Route $route )
    {
        /* @var $request \Insomnia\Request */
        $request = Registry::get( 'request' );
        
        /* @var $reflectionMethod \ReflectionMethod */
        $reflectionMethod = $route->getReflectionMethod();

        if( false === $reflectionMethod )
            throw new DispatcherMethodException( 'Unsupported Method ' . $request->getMethod() . ' on ' . $request->getParam( 'path' ) );
        
        $class = $reflectionMethod->getDeclaringClass()->getName();

        if( !ClassLoader::classExists( $class ) )
            throw new DispatcherControllerException( 'Failed to dispatch request' );

        if( self::STRICT_CHECKING )
            new \ReflectionClass( $class );
        
        Registry::get( 'request' )->mergeParams( $route->getMatches() );
        
        $this->setRoute( $route );
        $this->instantiate( $class );
        $this->controller->{$reflectionMethod->getName()}();
        
        $this->controller->getResponse()->render();
    }
    
    private function instantiate( $class )
    {
        try {
            $this->setController( new $class );
        }
        catch( \Exception $e )
        {
            if( $e instanceof \PDOException )
                throw new DatabaseException( 'Database error', null, $e );

            else throw $e;
        }
    }
    
    public function getController()
    {
        return $this->controller;
    }

    public function setController( $controller )
    {
        $this->controller = $controller;
    }
    
    public function getRoute()
    {
        return $this->route;
    }

    public function setRoute( $route )
    {
        $this->route = $route;
    }
}

class DispatcherControllerException extends \Exception {};
class DispatcherMethodException extends \Exception {};