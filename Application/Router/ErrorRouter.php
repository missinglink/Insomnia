<?php

namespace Application\Router;

use \Insomnia\Router\Route,
    \Insomnia\Router\RouterException;
        
class ErrorRouter
{
    public function setException( \Exception $e )
    {
        $route = new Route( '/.*' );
        $route->setDefault( 'controller', 'errors' )
              ->setDefault( 'exception', $e )
              ->setAction( 'ANY',    'error' )
              ->match();

        throw new RouterException( 'Failed to Match any Routes' );
    }
}