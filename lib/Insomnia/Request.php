<?php

namespace Insomnia;

use \Insomnia\Pattern\Subject;
use \Insomnia\Request\Plugin\ParamParser,
    \Insomnia\Request\Plugin\HeaderParser,
    \Insomnia\Request\Plugin\BodyParser,
    \Insomnia\Request\Plugin\MethodOverride;

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
        // Run all request plugins
        foreach( \Insomnia\Kernel::getInstance()->getRequestPlugins() as $plugin )
        {
            $plugin->update( $this );
        }
    }

    /**
     * Get HTTP request method
     *
     * @return string HTTP method
     */
    public function getMethod()
    {
        return strtoupper( $this->getHeader( 'Method' ) );
    }
    
    /**
     * Get HTTP request URI
     *
     * @return string HTTP URI
     */
    public function getUri()
    {
        return $this->getScheme() . '://' . $this->getHeader( 'Host' ) . 
               str_ireplace( $this->getFileExtension(), '', $this->getParam( 'path' ) );
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
        return strstr( $this->getHeader( 'Host' ) . '.', '.', true );
    }

    /**
     * Get URI file extension if applicable
     *
     * @return string|false File extension
     */
    public function getFileExtension()
    {
        preg_match( '%^.*/[^/]+?(?<extension>\.[^/]+)$%', $this->getParam( 'path' ), $matches );
        return isset( $matches[ 'extension' ] ) ? $matches[ 'extension' ] : false;
    }

    /**
     * Get HTTP content type
     *
     * @return string Content type
     */
    public function getContentType()
    {
        return strstr( $this->getHeader( 'Content-Type' ) . ';', ';', true );
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
        if( is_string( $body ) ) $this->body = $body;
    }

    /**
     * Get all request parameters
     *
     * @return array List of defined parameters
     */
    public function getParams()
    {
        return $this->params;
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
        if( is_array( $params ) ) $this->params = $params + $this->params;
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