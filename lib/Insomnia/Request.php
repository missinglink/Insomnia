<?php

namespace Insomnia;

use \Insomnia\ArrayAccess;

class Request extends ArrayAccess
{
    public function __construct()
    {
        $this->merge( $_REQUEST );
        $this->merge( \parse_url( $_SERVER['REQUEST_URI'] ) );
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
        if( substr_count( $_SERVER['HTTP_HOST'], '.' ) > 1 )
            return \substr( $_SERVER['HTTP_HOST'], 0, \strpos( $_SERVER['HTTP_HOST'], '.' ) );
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

    private function parseHeaders()
    {
        $this->addHeaders( $_SERVER, 'HTTP_' );
        $this->addHeaders( $_SERVER, 'REQUEST_' );
        if( function_exists( 'apache_request_headers' ) )
            $this->addHeaders( apache_request_headers() );
    }

    public function getHeader( $header )
    {
        switch( $header )
        {
            case 'Accept':          return $_SERVER['HTTP_ACCEPT'];
            case 'Accept-Charset':  return $_SERVER['HTTP_ACCEPT_CHARSET'];
            case 'Accept-Encoding': return $_SERVER['HTTP_ACCEPT_ENCODING'];
            case 'Accept-Language': return $_SERVER['HTTP_ACCEPT_LANGUAGE'];
            case 'Referer':         return $_SERVER['HTTP_REFERER'];
            case 'User-Agent':      return $_SERVER['HTTP_USER_AGENT'];
        }

        if( !is_array( $this[ 'headers' ] ) || empty( $this[ 'headers' ] ) ) $this->parseHeaders();
        return isset( $this[ 'headers' ][ $header ] )
            ? $this[ 'headers' ][ $header ]
            : null;
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

            $this->data[ 'headers' ][ $k ] = $v;
        }
    }
}