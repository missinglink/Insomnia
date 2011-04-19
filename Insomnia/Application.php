<?php

namespace Insomnia;

class Application
{
    private $router;
    private $exceptionHandler = 'Insomnia\Error';
    public static $config;

    public function __construct()
    {
        self::$config = new \ArrayObject;
        self::$config[ 'path' ] = array();
        
        $this->showErrors();
        $this->setRouter( new Router );
    }

    public function run( Request $request )
    {
        try {
            $this->router->dispatch( $request );
        }
        
        catch( \Exception $e )
        {
            new $this->exceptionHandler( $e );
        }
    }

    public function showErrors( $bool = true )
    {
        \error_reporting( true === $bool ? \E_ALL : 0 );
        \ini_set( 'display_errors', true === $bool ? 'On' : 'Off' );
    }

    public function setExceptionHandler( $class = 'Error' )
    {
        $this->exceptionHandler = $class;
    }

    public function setRouter( Router $router )
    {
        $this->router = $router;
    }    
}

//class Config extends Data
//{
//    public function __construct()
//    {
//        $this['paths'] = array();
//    }
//}