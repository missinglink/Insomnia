<?php

namespace Insomnia\Dispatcher;

use \Insomnia\Pattern\Subject,
    \Insomnia\Router\AnnotationReader,
    \Insomnia\Validator\DatabaseException;

use \Insomnia\Dispatcher\Plugin\ViewAnnotationReader,
    \Insomnia\Dispatcher\Plugin\ParamAnnotationValidator,
    \Insomnia\Dispatcher\Plugin\DocumentationEndPoint;

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

        $this->attach( new DocumentationEndPoint );
        $this->attach( new ViewAnnotationReader );
        $this->attach( new ParamAnnotationValidator );
        $this->notify();
    }
    
    public function dispatch()
    {
        try {
            \call_user_func( array( $this->getController(), $this->getMethod() ) );
        }
        catch( \Exception $e )
        {
            if( $e instanceof \PDOException )
                throw new DatabaseException( 'Database error', null, $e );

            else throw $e;
        }
        
        if( \method_exists( $this->getController(), 'getResponse' ) )
            $this->getController()->getResponse()->render();
    }
    
    private function reflect()
    {
        $this->annotationReader  = new AnnotationReader;
        $this->reflectionClass   = new \ReflectionClass( $this->getClass() );
        $this->reflectionMethod  = $this->reflectionClass->getMethod( $this->getMethod() );
        $this->methodAnnotations = $this->annotationReader->getMethodAnnotations( $this->reflectionMethod );
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

    private function setMethod( $method )
    {
        $this->method = $method;
    }
    
    public function getController()
    {
        return $this->controller;
    }

    public function setController( $controller )
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