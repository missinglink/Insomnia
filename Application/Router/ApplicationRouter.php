<?php

namespace Application\Router;

use \Insomnia\Router\Route,
    \Insomnia\Router\RouterException;

class ApplicationRouter
{
    public function __construct()
    {
        $params = array();
        $params[ 'version' ]    = 'v\d+';
        $params[ 'controller' ] = '[a-z]+';
        $params[ 'id' ]         = '\w+';

        $route = new Route( '/ping.*' );
        $route->setDefault( 'controller', 'status' )
              ->setAction( 'ANY',    'status' )
              ->match();

        $route = new Route( '/:version/:controller' );
        $route->setParams( $params )
              ->setAction( 'POST',   'create' )
              ->setAction( 'GET',    'index' )
              ->match();

        $route = new Route( '/:version/:controller/:id' );
        $route->setParams( $params )
              ->setAction( 'GET',    'read' )
              ->setAction( 'HEAD',   'read' )
              ->setAction( 'PUT',    'update' )
              ->setAction( 'DELETE', 'delete' )
              ->match();

        throw new RouterException( 'Failed to Match any Routes' );
    }
}