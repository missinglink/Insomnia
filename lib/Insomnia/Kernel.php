<?php

namespace Insomnia;

use \Insomnia\Pattern\KernelModule,
    \Insomnia\Controller\Action,
    \Insomnia\Router,
    \Insomnia\Pattern\PriorityQueue;

class Kernel
{
    private static $router;
    private static $dispatcherPlugins = array();
    private static $requestPlugins = array();
    private static $responsePlugins;
    private static $modules = array();
    private static $endPoints = array();
    private static $annotationAliases = array();
    
    public static function addDispatcherPlugin( $plugin )
    {
        self::$dispatcherPlugins[] = $plugin;
    }
    
    public static function getDispatcherPlugins()
    {
        return self::$dispatcherPlugins;
    }
    
    public static function addRequestPlugin( $plugin )
    {
        self::$requestPlugins[] = $plugin;
    }
    
    public static function getRequestPlugins()
    {
        return self::$requestPlugins;
    }

    public static function addResponsePlugin( $plugin, $level = 50 )
    {
        if( !isset( self::$responsePlugins ) ) self::$responsePlugins = new PriorityQueue;
        self::$responsePlugins->insert( $plugin, -$level );
    }

    public static function getResponsePlugins()
    { 
        $return = array();
        
        if( 0 < self::$responsePlugins->count() )
        {
            $plugins = clone self::$responsePlugins;
            
            while( $plugins->valid() )
            {
                $return[] = $plugin = $plugins->current();
                $plugins->next();
            }
        }
        
        return $return;
    }

    public static function addModule( KernelModule $component )
    {
        self::$modules[] = $component;

    }
    
    public static function getModules()
    {
        return self::$modules;
    }
   
    public static function addEndpoint( $endPoint )
    {
        self::$endPoints[] = $endPoint;
    }
    
    public static function getEndPoints()
    {
        return self::$endPoints;
    }
    
    public static function run()
    {
        if( !isset( self::$router ) ) self::setRouter( new Router );
        
        foreach( self::getModules() as $module )
        {
            $module->run();
        }
        
        foreach( self::getEndpoints() as $endPoint )
        {
            self::getRouter()->addClass( $endPoint );
        }    
        
        self::getRouter()->dispatch( new Request );
    }
    
    public static function getAnnotationAliases()
    {
        return self::$annotationAliases;
    }

    public static function setAnnotationAliases( $annotationAliases )
    {
        self::$annotationAliases = $annotationAliases;
    }

    public static function addAnnotationAlias( $alias, $classPath = 'Insomnia\Annotation\\' )
    {
        self::$annotationAliases[ $alias ] = $classPath;
    }

    public static function removeAnnotationAlias( $alias )
    {
        if( isset( self::$annotationAliases[ $alias ] ) ) unset( self::$annotationAliases[ $alias ] );
    }
    
    /** @return Router */
    public static function getRouter()
    {
        return self::$router;
    }

    public static function setRouter( $router )
    {
        self::$router = $router;
    }
}