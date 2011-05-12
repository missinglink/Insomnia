<?php

namespace Insomnia;

use \Insomnia\ArrayAccess;

class Request extends ArrayAccess
{
    private $headers = array(),
            $body = null;

    public function __construct()
    {
        $this->merge( \array_filter( $_REQUEST ) );
        $this->merge( \parse_url( $_SERVER['REQUEST_URI'] ) );
        $this->parseBody();
    }

    public function getUri()
    {
        return \strtolower( $_SERVER['REQUEST_URI'] );
    }

    public function getMethod()
    {
        return \strtoupper( $_SERVER['REQUEST_METHOD'] );
    }

    public function getScheme()
    {
        return isset( $_SERVER['HTTPS'] ) ? 'https' : 'http';
    }

    public function getHost()
    {
        return \strtolower( $_SERVER['HTTP_HOST'] );
    }

    public function getCname()
    {
        if( \substr_count( $_SERVER['HTTP_HOST'], '.' ) > 1 )
            return \substr( $_SERVER['HTTP_HOST'], 0, \strpos( $_SERVER['HTTP_HOST'], '.' ) );
    }

    public function getFileExtension()
    {
        $uri = $_SERVER['REQUEST_URI'];
        return ( false !== \strrpos( $uri, '.', \strpos( $uri, '/' ) ) ) ? \strrchr( $uri, '.' ) : '';
    }

    public function getPath()
    {
        if( empty( $this ) ) $this->parseUrl();
        return isset( $this[ 'path' ] ) ? $this[ 'path' ] : null;
    }

    public function getQuery()
    {
        if( empty( $this ) ) $this->parseUrl();
        return isset( $this[ 'query' ] ) ? $this[ 'query' ] : null;
    }

    public function getFragment()
    {
        if( empty( $this ) ) $this->parseUrl();
        isset( $this[ 'fragment' ] ) ? $this[ 'fragment' ] : null;
    }

    public function getHeaders()
    {
        return $this->headers;
    }
    
    public function getContentType()
    {
        $contentType = explode( ';', $this->getHeader( 'Content-Type' ) );
        return \reset( $contentType );
    }

    public function getHeader( $header )
    {
        if( !is_array( $this->headers ) || empty( $this->headers ) )
            $this->parseHeaders();
        
        return isset( $this->headers[ $header ] )
            ? $this->headers[ $header ]
            : null;
    }
    
    public function getBody()
    {
        return $this->body;
    }
    
    private function parseHeaders()
    {
        $this->addHeaders( $_SERVER, 'HTTP_' );
        $this->addHeaders( $_SERVER, 'REQUEST_' );
        if( \function_exists( 'apache_request_headers' ) )
            $this->addHeaders( \apache_request_headers() );
    }

    private function addHeaders( $headers, $match = false, $normalize = true )
    {
        foreach( $headers as $k => $v )
        {
            if( \is_string( $match ) )
            {
                if( \substr( $k, 0, \strlen( $match ) ) !== $match ) continue;
                else $k = \str_replace( $match, '', $k );
            }

            if( true === $normalize )
            {
                $k = \ucfirst( \strtolower( $k ) );               
                $k = \preg_replace( '/[_-](.+)/e', '"-".ucfirst("$1")', $k );
            }

            $this->headers[ $k ] = $v;
        }
    }

    private function parseBody()
    {
        switch( $this->getMethod() )
        {
            case 'PUT': case 'POST':
                $this->body = \trim( \file_get_contents( 'php://input' ) );

                if( \strlen( $this->body ) )
                {
                    switch( $this->getContentType() )
                    {
                        case 'application/json' :
                            $json = \json_decode( $this->body, true );
                            if( null !== $json ) $this->merge( $json );
                            break;

                        case 'application/x-www-form-urlencoded' :
                        default :
                            \parse_str( $this->body, $params );
                            $this->merge( \array_filter( $params ) );
                    }
                }
        }
    }
}