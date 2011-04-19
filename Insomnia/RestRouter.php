<?php

namespace Insomnia;

class RestRouter extends Router
{
    public function __construct()
    {
        $route = new RegexRoute( '_^/?v1/([a-z]+)/(\w+).?$_', array( 'controller', 'id' ) );
        $route->setAction( 'GET',    'read' )
              ->setAction( 'HEAD',   'read' )
              ->setAction( 'PUT',    'update' )
              ->setAction( 'DELETE', 'delete' )
              ->appendTo( $this );

        $route = new RegexRoute( '_^/?v1/([a-z]+).?$_', array( 'controller' ) );
        $route->setAction( 'POST',  'create' )
              ->setAction( 'GET',   'index' )
              ->appendTo( $this );
    }

    public function preDispatch( Request $request, RegexRoute $route )
    {
        switch( $request->getMethod() )
        {
            case 'POST':
                \header( $_SERVER[ 'SERVER_PROTOCOL' ] . ' 201 Created' );
                break;

            default:
                \header( $_SERVER[ 'SERVER_PROTOCOL' ] . ' 200 OK' );
        }
    }
}