<?php

namespace Application\Router;

use \Insomnia\Router\Route,
    \Insomnia\Router\RouterAbstract;
        
class ErrorRouter extends RouterAbstract
{
    public function setException( \Exception $e )
    {
        $route = new Route( '/.*' );
        $route->setDefault( 'controller', 'errors' )
              ->setDefault( 'exception', $e )
              ->setAction( 'ANY',    'error' );
        $this->match( $route );
    }
}