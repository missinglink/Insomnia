<?php

namespace Community\Module\Console\Controller;

use \Community\Module\Console\Controller\Action,
    \Insomnia\Kernel;

use \Insomnia\Annotation\Parser\Route as RouteParser;
use \Insomnia\Annotation\Parser\ParamParser;
use \Insomnia\Annotation\Parser\Documentation;
use \Insomnia\Router\AnnotationReader;
use \Insomnia\Registry;

/**
 * WebService Documentation
 * 
 * @insomnia:Resource
 * 
 */
class KernelController extends Action
{       
    /**
     * Debug Kernel
     * 
     * @insomnia:Route( "/info", name="kernel_debug" )
     * @insomnia:Method( "GET" )
     * @insomnia:Documentation( title="Kernel Debug", description="Debug Kernel Object", category="CLI" )
     *
     */
    public function index()
    {
        /* @var $kernel \Insomnia\Kernel */
        $kernel = Kernel::getInstance();
        
        $this->outputTitle();

        $this->outputHeader( 'Modules' );
        /* @var $component \Insomnia\Pattern\KernelModule */
        foreach( $kernel->getModules() as $module )
        {
            preg_match( '#Module\\\\(?<name>.+)\\\\Bootstrap#', get_class( $module ), $moduleName ); 
            
            if( isset( $moduleName[ 'name' ] ) )
            {
                $this->outputString( str_pad( '  - [' . $moduleName[ 'name' ] . ']', 30, ' ' ) . get_class( $module ) );
            }
            
            else {
                $this->outputString( '  - ' . get_class( $module ) );
            }
        }
        echo PHP_EOL;
        
        $this->outputHeader( 'Controllers' );
        /* @var $endPoint \Insomnia\Dispatcher\EndPoint */
        foreach( $kernel->getEndPoints() as $endPoint )
        {
            $this->outputString( '  - ' . $endPoint );
        }
        echo PHP_EOL;
        
        $this->outputHeader( 'Dispatcher Plugins' );
        /* @var $plugin \Insomnia\Dispatcher\EndPoint */
        foreach( $kernel->getDispatcherPlugins() as $plugin )
        {
            $this->outputString( '  - ' . get_class( $plugin ) );
        }
        echo PHP_EOL;
        
        $this->outputHeader( 'Request Plugins' );
        /* @var $plugin \Insomnia\Dispatcher\EndPoint */
        foreach( $kernel->getRequestPlugins() as $plugin )
        {
            $this->outputString( '  - ' . get_class( $plugin ) );
        }
        echo PHP_EOL;
        
        $this->outputHeader( 'Response Plugins' );
        /* @var $plugin \Insomnia\Dispatcher\EndPoint */
        foreach( $kernel->getResponsePlugins() as $plugin )
        {
           $this->outputString( '  - ' . get_class( $plugin ) );
        }
        echo PHP_EOL;
        
        $this->outputHeader( 'Routes' );
        foreach( \Insomnia\Kernel::getInstance()->getEndPoints() as $controllerClass )
        {
            $reader = new AnnotationReader( $controllerClass );
            $routes = new RouteParser( $reader );
            
            /* @var $route \Insomnia\Router\Route */
            foreach( $routes->toArray() as $route )
            {
                foreach( $route->getMethods() as $method )
                {
                    $this->outputString( str_pad( str_pad( '  [' . $method . '] ', 15, ' ' ) . $route->getPattern(), 50, ' ' ) . ' ' . $controllerClass . '::' . $route->getReflectionMethod()->getName() . '()' );
                }
            }
        }
        echo PHP_EOL;
        
        die;
    }
}