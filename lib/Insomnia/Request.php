<?php

namespace Insomnia;

use \Insomnia\Pattern\Subject;
use \Insomnia\Request\ParamParser,
    \Insomnia\Request\HeaderParser,
    \Insomnia\Request\BodyParser,
    \Insomnia\Request\MethodOverride;

/**
 * HTTP request object
 *
 * Extensible by class extension or by attaching custom observers
 */
class Request extends Subject
{
    private $params     = array();
    private $headers    = array();
    private $method     = 'GET';
    private $body       = '';

    /**
     * Create a new request object
     */
    public function __construct()
    {
        $this->attach( new ParamParser );
        $this->attach( new HeaderParser );
        $this->attach( new BodyParser );
        $this->attach( new MethodOverride );
        $this->notify();
    }

    /**
     * Get HTTP request method
     *
     * @return string HTTP method
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * Set HTTP request method
     *
     * @param string $method HTTP method
     */
    public function setMethod( $method )
    {
        switch( $method = \strtoupper( $method ) )
        {
            case 'GET': case 'PUT': case 'POST': case 'DELETE':
            case 'HEAD': case 'STATUS': case 'TRACE':
                $this->method = $method;
        }
    }

    /**
     * Get HTTP scheme
     *
    * @return string Either 'http' or 'https'
     */
    public function getScheme()
    {
        return isset( $_SERVER['HTTPS'] ) ? 'https' : 'http';
    }

    /**
     * Get subdomain
     *
     * @return string Subdomain
     */
    public function getCname()
    {
        return \strstr( $this->getHeader( 'Host' ) . '.', '.', true );
    }

    /**
     * Get URI file extension if applicable
     *
     * @return string|false File extension
     */
    public function getFileExtension()
    {
        \preg_match( '%^.*/[^/]+?(?<extension>\.[^[/]+)$%', $this->getParam( 'path' ), $matches );
        return \array_key_exists( 'extension', $matches ) ? $matches[ 'extension' ] : false;
    }

    /**
     * Get HTTP content type
     *
     * @return string Content type
     */
    public function getContentType()
    {
        return \strstr( $this->getHeader( 'Content-Type' ) . ';', ';', true );
    }

    /**
     * Get an HTTP request header
     *
     * @param string $key HTTP header key
     * @return string|null HTTP header value
     */
    public function getHeader( $key )
    {
        return isset( $this->headers[ $key ] ) ? $this->headers[ $key ] : null;
    }

    /**
     * Get all HTTP request headers
     * 
     * @return array List of HTTP headers
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * Set an HTTP request header
     *
     * @param string $key HTTP header key
     * @param string $value HTTP header value
     */
    public function setHeader( $key, $value )
    {
        $this->headers[ $key ] = $value;
    }

    /**
     * Get the raw HTTP request body
     *
     * @return string Raw HTTP request body
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Set the raw HTTP request body
     *
     * @param string $body Raw HTTP request body
     */
    public function setBody( $body )
    {
        if( \is_string( $body ) ) $this->body = $body;
    }

    /**
     * Get a request parameter
     *
     * @param string $key Parameter key
     * @return mixed Parameter value
     */
    public function getParam( $key )
    {
        return isset( $this->params[ $key ] ) ? $this->params[ $key ] : null;
    }

    /**
     * Set a request parameter
     *
     * @param string $key Parameter key
     * @param mixed $value Parameter value
     */
    public function setParam( $key, $value )
    {
        $this->params[ $key ] = $value;
    }

    /**
     * Check if a request parameter has been set
     *
     * @param string $key Parameter key
     * @return boolean Boolean
     */
    public function hasParam( $key )
    {
        return isset( $this->params[ $key ] );
    }

    /**
     * Merge an array into request parameters
     *
     * @param array $params Parameters
     */
    public function mergeParams( $params )
    {
        if( \is_array( $params ) ) $this->params = $params + $this->params;
    }

    /**
     * Retrieve all request parameters as an array
     *
     * @return array Parameters
     */
    public function toArray()
    {
        return $this->params;
    }
}