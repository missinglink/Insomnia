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
        return \substr_count( $_SERVER['HTTP_HOST'], '.' ) > 1
            ? \strstr( $_SERVER['HTTP_HOST'], '.', true ) : '';
    }

    /**
     * @return string|false
     */
    public function getFileExtension()
    {
        return \strrchr( \strrchr( $_SERVER['REQUEST_URI'], '/' ), '.' );
    }

    public function getPath()
    {
        return isset( $this[ 'path' ] ) ? $this[ 'path' ] : null;
    }

    public function getQuery()
    {
        return isset( $this[ 'query' ] ) ? $this[ 'query' ] : null;
    }

    public function getFragment()
    {
        isset( $this[ 'fragment' ] ) ? $this[ 'fragment' ] : null;
    }

    public function getHeaders()
    {
        return $this->headers;
    }
    
    public function getContentType()
    {
        return \strstr( $this->getHeader( 'Content-Type' ) . ';', ';', true );
    }

    public function getHeader( $header )
    {
        if( empty( $this->headers ) )
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
    }

    private function addHeaders( $headers, $match = false )
    {
        $matchLength = \is_string( $match ) ? \strlen( $match ) : false;

        foreach( $headers as $k => $v )
        {
            if( false !== $matchLength )
            {
                if( \strncmp( $k, $match, $matchLength ) ) continue;
                else $k = \substr( $k, $matchLength );
            }

            /* Format Key */
            $k = \strtr( \ucwords( \strtolower( \strtr( $k, '_', ' ' ) ) ), ' ', '-' );

            $this->headers[ $k ] = $v;
        }
    }

    private function parseBody()
    {
        switch( $this->getMethod() )
        {
            case 'GET': break;
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