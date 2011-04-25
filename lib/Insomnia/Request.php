<?php

namespace Insomnia;

use \Insomnia\ArrayAccess;

class Request extends ArrayAccess
{
    private $url = array();

    public function __construct()
    {
        $this->merge( $_REQUEST );
    }

    public function getScheme()
    {
        if( empty( $this->url ) ) $this->parseUrl();
        return $this->url[ 'scheme' ];
    }

    public function getHost()
    {
        if( empty( $this->url ) ) $this->parseUrl();
        return $this->url[ 'host' ];
    }

    public function getUser()
    {
        if( empty( $this->url ) ) $this->parseUrl();
        return $this->url[ 'user' ];
    }

    public function getPass()
    {
        if( empty( $this->url ) ) $this->parseUrl();
        return $this->url[ 'pass' ];
    }

    public function getPath()
    {
        if( empty( $this->url ) ) $this->parseUrl();
        return $this->url[ 'path' ];
    }

    public function getQuery()
    {
        if( empty( $this->url ) ) $this->parseUrl();
        return $this->url[ 'query' ];
    }

    public function getFragment()
    {
        if( empty( $this->url ) ) $this->parseUrl();
        return $this->url[ 'fragment' ];
    }

    private function parseHeaders()
    {
        $this->addHeaders( $_SERVER, 'HTTP_' );
        if( function_exists( 'apache_request_headers' ) )
            $this->addHeaders( apache_request_headers() );
    }

    private function parseUrl()
    {
        $this->url = \parse_url( $_SERVER['REQUEST_URI'] );
    }

    public function getMethod()
    {
        return \strtoupper( $_SERVER['REQUEST_METHOD'] );
    }

    public function getHeader( $header )
    {
        if( !isset( $this[ 'headers' ] ) || empty( $this[ 'headers' ] ) ) $this->parseHeaders();
        
        return isset( $this[ 'headers' ][ $header ] )
            ? $this[ 'headers' ][ $header ]
            : null;
    }

    public function getHeaders()
    {
        if( !isset( $this[ 'headers' ] ) || empty( $this[ 'headers' ] ) ) $this->parseHeaders();
        return $this[ 'headers' ];
    }

    private function addHeaders( $headers, $match = false, $normalize = true )
    {
        foreach( $headers as $k => $v )
        {
            if( is_string( $match ) )
            {
                if( substr( $k, 0, strlen( $match ) ) !== $match ) continue;
                else $k = str_replace( $match, '', $k );
            }

            if( true === $normalize )
            {
                $k = \ucfirst( \strtolower( $k ) );
                $k = preg_replace( '/[_-](.+)/e', '"-".ucfirst("$1")', $k );
            }

            $this->data[ 'headers' ][ $k ] = $v;
        }
    }
}