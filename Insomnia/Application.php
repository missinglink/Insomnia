<?php

namespace Insomnia;

class Application
{
    private $router;
    private $exceptionHandler = 'Error';

    public function __construct()
    {
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