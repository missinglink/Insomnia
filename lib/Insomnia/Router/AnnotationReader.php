<?php

namespace Insomnia\Router;

use \Insomnia\Router\RouteStack,
    \Doctrine\Common\Annotations\AnnotationReader as DoctrineAnnotationReader;

class AnnotationReader
{
    private $reader;
    private $reflector;
    private $alias = array( 'insomnia' => 'Insomnia\Annotation\\' );
    
    public function __construct( $className )
    {
        $reader = new DoctrineAnnotationReader;
        $reader->setAutoloadAnnotations( true );
        
        foreach( $this->alias as $k => $v )
            $reader->setAnnotationNamespaceAlias( $v, $k );
        
        $this->setReader( $reader );
        $this->setReflector( new \ReflectionClass( $className ) );
    }
    
    public function getClassAnnotations()
    {
        return $this->getReader()->getClassAnnotations( $this->getReflector() );
    }
    
    public function getMethodAnnotations( $method )
    {
        return $this->getReader()->getMethodAnnotations( $method );
    }
    
    public function getReflectionClass()
    {
        return $this->getReflector();
    }
    
    public function getReflectionMethods()
    {
        return $this->getReflector()->getMethods();
    }
    
    public function getReader()
    {
        return $this->reader;
    }

    public function setReader( $reader )
    {
        $this->reader = $reader;
    }
    
    /**
     * @return \ReflectionClass 
     */
    public function getReflector()
    {
        return $this->reflector;
    }

    public function setReflector( \ReflectionClass $reflector )
    {
        $this->reflector = $reflector;
    }
}