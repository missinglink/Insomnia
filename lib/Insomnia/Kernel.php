<?php

namespace Insomnia;

use \Insomnia\Pattern\KernelModule,
    \Insomnia\Controller\Action,
    \Insomnia\Router,
    \Insomnia\Pattern\PriorityQueue;

class Kernel
{
    private static $_instance;
    
    private $router;
    private $dispatcherPlugins = array();
    private $requestPlugins = array();
    private $responsePlugins;
    private $modules = array();
    private $endPoints = array();
    
    public function __construct()
    {
        $this->setRouter( new Router );
        $this->responsePlugins = new PriorityQueue;
    }
    
    public function addDispatcherPlugin( $plugin )
    {
        $this->dispatcherPlugins[] = $plugin;
        
        return $this;
    }
    
    public function getDispatcherPlugins()
    {
        return $this->dispatcherPlugins;
    }
    
    public function addRequestPlugin( $plugin )
    {
        $this->requestPlugins[] = $plugin;
        
        return $this;
    }
    
    public function getRequestPlugins()
    {
        return $this->requestPlugins;
    }

    public function addResponsePlugin( $plugin, $level = 50 )
    {
        $this->responsePlugins->insert( $plugin, -$level );
  
        return $this;
    }

    public function getResponsePlugins()
    { 
        $return = array();
        
        if( 0 < $this->responsePlugins->count() )
        {
            $plugins = clone $this->responsePlugins;
            
            while( $plugins->valid() )
            {
                $return[] = $plugin = $plugins->current();
                $plugins->next();
            }
        }
        
        return $return;
    }

    public function addModule( KernelModule $component )
    {
        $this->modules[] = $component;
        
        return $this;
    }
    
    public function getModules()
    {
        return $this->modules;
    }
   
    public function addEndpoint( $endPoint )
    {
        $this->endPoints[] = $endPoint;
        
        return $this;
    }
    
    public function getEndPoints()
    {
        return $this->endPoints;
    }
    
    public function run()
    {
        foreach( $this->getModules() as $module )
        {
            $module->bootstrap( $this );
        }
        
        foreach( $this->getEndpoints() as $endPoint )
        {
            $this->getRouter()->addClass( $endPoint );
        }    
        
        $this->getRouter()->dispatch();
        
        return $this;
    }
    
    /** @return Router */
    public function getRouter()
    {
        return $this->router;
    }

    public function setRouter( $router )
    {
        $this->router = $router;
    }

    /** @return \Insomnia\Kernel */
    public static function getInstance()
    {
        if( is_null( self::$_instance ) )
        {
            self::$_instance = new self;
        }
        
        return self::$_instance;
    }
}