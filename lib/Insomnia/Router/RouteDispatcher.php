<?php

namespace Insomnia\Router;

use \Doctrine\Common\ClassLoader,
    \Insomnia\Router\Route,
    \Insomnia\Dispatcher\EndPoint,
    \Insomnia\Registry;

use \Insomnia\Router\DispatcherControllerException,
    \Insomnia\Router\DispatcherMethodException;

class RouteDispatcher
{
    /* @var STRICT_CHECKING boolean Check if class is semantically valid */
    const STRICT_CHECKING = true;

    public function __construct( Route $route )
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
        
        $endpoint = new EndPoint( $class, $reflectionMethod->getName() );
        $endpoint->dispatch();
    }
}