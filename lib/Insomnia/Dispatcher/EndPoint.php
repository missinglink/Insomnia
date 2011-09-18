<?php

namespace Insomnia\Dispatcher;

use \Insomnia\Pattern\Subject,
    \Insomnia\Router\AnnotationReader,
    \Insomnia\Validator\DatabaseException;

use \Insomnia\Controller\Action;

use \Insomnia\Router\RouterException;

class EndPoint extends Subject
{
    private $class,
            $method,
            $controller;
    
    private $annotationReader,
            $reflectionClass,
            $reflectionMethod,
            $methodAnnotations;

    public function __construct( $class, $method )
    {
        $this->setClass( $class );
        $this->setMethod( $method );
        $this->reflect();

        // Instantiate controller
        $this->setController( new $class );

        foreach( \Insomnia\Kernel::getInstance()->getDispatcherPlugins() as $plugin )
        {
            $plugin->update( $this );
        }

        $this->notify();
    }
    
    public function dispatch()
    {
        try {
            \call_user_func_array( array( $this->getController(), $this->getMethod() ), func_get_args() );
        }
        catch( \Exception $e )
        {
            if( $e instanceof \PDOException )
                throw new DatabaseException( 'Database error', null, $e );

            else throw $e;
        }

        if( \method_exists( $this->getController(), 'getResponse' ) )
            $this->getController()->getResponse()->render( $this );
    }
    
    private function reflect()
    {
        try {
            $this->annotationReader  = new AnnotationReader( $this->getClass() );
            $this->reflectionMethod  = $this->annotationReader->getReflector()->getMethod( $this->getMethod() );
            $this->methodAnnotations = $this->annotationReader->getMethodAnnotations( $this->reflectionMethod );
        }
        catch( \Exception $e )
        {
            throw new RouterException( 'Invalid Endpoint Specified: ' . (string) $this->getClass(), null, $e );
        }
    }
    
    public function getClass()
    {
        return $this->class;
    }

    private function setClass( $class )
    {
        $this->class = $class;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function setMethod( $method )
    {
        $this->method = $method;
    }
    
    /**
     * @return \Insomnia\Controller\Action 
     */
    public function getController()
    {
        return $this->controller;
    }

    public function setController( Action $controller )
    {
        $this->controller = $controller;
    }
   
    public function getAnnotationReader()
    {
        return $this->annotationReader;
    }

    private function setAnnotationReader( $annotationReader )
    {
        $this->annotationReader = $annotationReader;
    }

    public function getReflectionClass()
    {
        return $this->reflectionClass;
    }

    private function setReflectionClass( $reflectionClass )
    {
        $this->reflectionClass = $reflectionClass;
    }

    public function getReflectionMethod()
    {
        return $this->reflectionMethod;
    }

    private function setReflectionMethod( $reflectionMethod )
    {
        $this->reflectionMethod = $reflectionMethod;
    }

    public function getMethodAnnotations()
    {
        return $this->methodAnnotations;
    }

    public function setMethodAnnotations( $methodAnnotations )
    {
        $this->methodAnnotations = $methodAnnotations;
    }
}