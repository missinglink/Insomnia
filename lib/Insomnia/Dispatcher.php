<?php

namespace Insomnia;

use \Doctrine\Common\ClassLoader,
    \Insomnia\Router\Route,
    \Insomnia\Controller\PluginInterface,
    \Insomnia\Registry,
    Insomnia\Validator\DatabaseException;

use \Insomnia\Annotation\Parser\ViewParser;
use \Insomnia\Router\AnnotationReader;

class Dispatcher
{
    /* @var STRICT_CHECKING boolean Check if class is semantically valid */
    const STRICT_CHECKING = true;

    private $controller;
    private $route;
    
    public function dispatchRoute( Route $route )
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
        $this->dispatch( $class, $reflectionMethod->getName() );
    }
    
    public function dispatch( $class, $method )
    {
        
        try {
            $this->setController( new $class );
            
            //-- Read Annotations
            $reader = new AnnotationReader( $class );
            $reflectionClass = new \ReflectionClass( $class );
            $reflectionMethod = $reflectionClass->getMethod( $method );
            $methodAnnotations = $reader->getMethodAnnotations( $reflectionMethod );
            
             //-- Setup View 
            $viewAnnotation = new ViewParser( $methodAnnotations );
            if( isset( $viewAnnotation['value'] ) )
                $this->getController()->getResponse()->setView( $viewAnnotation['value'] );
            
            // @todo Abstract this to a dispatcher plugin
            //-- Parameter Validation
            $params = new \Insomnia\Annotation\Parser\ParamParser( $methodAnnotations );

            foreach( $params as $param )
            {
                switch( $param[ 'type' ] )
                {
                    case 'integer' : $validator = new \Insomnia\Request\Validator\IntegerValidator( 1, 10 ); break;
                    case 'string' : $validator = new \Insomnia\Request\Validator\StringValidator( 1, 10 ); break;
                }

                if( !isset( $validator ) ) throw new Exception( 'Unsupported Request Type "' . $param[ 'type' ] . '"' );

                if( isset( $param[ 'optional' ] ) )
                    $this->getController()->getValidator()->optional( $param[ 'name' ], $validator );
                else
                    $this->getController()->getValidator()->required( $param[ 'name' ], $validator );
            }

            $this->getController()->getValidator()->validate();
            
             //-- Response Renderer
            $this->getController()->{$reflectionMethod->getName()}();
            $this->getController()->getResponse()->render();
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