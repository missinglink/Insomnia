<?php

namespace Insomnia\Router;

use \Doctrine\Common\Annotations;
use \Doctrine\Common\Cache\ApcCache,
    \Doctrine\Common\Cache\ArrayCache;

class AnnotationReader
{
    private $reader;
    private $reflector;

    public function __construct( $className )
    {
        $reflectionClass = new \ReflectionClass( $className );
        
//        $cache = ( \APPLICATION_ENV !== 'development' && extension_loaded( 'apc' ) )
//            ? new \Doctrine\Common\Cache\ApcCache
//            : new \Doctrine\Common\Cache\ArrayCache;
        

        Annotations\AnnotationRegistry::registerAutoloadNamespace( 'Insomnia\Annotation', \ROOT . 'lib' );
        Annotations\AnnotationRegistry::registerAutoloadNamespace( 'Doctrine\ORM', \ROOT . 'lib/doctrine-orm/lib' );
        
        $this->setReader( new \Doctrine\Common\Annotations\IndexedReader( new Annotations\AnnotationReader ) );
        $this->setReflector( $reflectionClass );
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