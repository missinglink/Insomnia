<?php

namespace Insomnia;

use \Insomnia\Pattern\KernelModule,
    \Insomnia\Controller\Action,
    \Insomnia\Router;

class Kernel
{
    private static $_instance;
    
    private $router;
    private $dispatcherPlugins = array();
    private $requestPlugins = array();
    private $responsePlugins = array();
    private $modules = array();
    private $endPoints = array();
    
    public function __construct()
    {
        $this->setRouter( new Router );
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

    public function addResponsePlugin( $plugin )
    {
        return $this->responsePlugins[] = $plugin;
        
        return $this;
    }

    public function getResponsePlugins()
    {
        return $this->responsePlugins;
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
        
        Registry::set( 'request', new Request );
        
        $this->getRouter()->dispatch();
        
        return $this;
    }
    
    public function getRouter()
    {
        return $this->router;
    }

    public function setRouter( $router )
    {
        $this->router = $router;
    }

    public static function getInstance()
    {
        if( is_null( self::$_instance ) )
        {
            self::$_instance = new self;
        }
        
        return self::$_instance;
    }
}