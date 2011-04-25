<?php

namespace Insomnia\Router;
        
class ErrorRouter extends RouterAbstract
{
    public function setException( \Exception $e )
    {
        $route = new Route( '/.*' );
        $route->setDefault( 'controller', 'error' )
              ->setDefault( 'exception', $e )
              ->setAction( 'GET',    'error' );
        $this[] = $route;
    }
}