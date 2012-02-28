<?php

namespace Community\Module\Testing\Transport;

class HTTPRequest
{
    private $protocol = 'http';
    private $domain = 'localhost';
    private $uri = '/';
    private $headers = array();
    private $method = 'GET';
    private $params = array();
    
    public function __construct( $uri = null, $method = null )
    {
        if( isset( $uri ) )
        {
            $this->setUri( $uri );
        }
        
        if( isset( $method ) )
        {
            $this->setMethod( $method );
        }
    }
    
    public function getProtocol()
    {
        return $this->protocol;
    }

    public function setProtocol( $protocol )
    {
        $this->protocol = $protocol;
    }

    public function getDomain()
    {
        return $this->domain;
    }

    public function setDomain( $domain )
    {
        $this->domain = $domain;
    }
    
    public function getUri()
    {
        return $this->uri;
    }

    public function setUri( $uri )
    {
        if( '/' !== substr( $uri, 0, 1 ) )
        {
            throw new \Exception( 'URI must begin with a slash: "' . $uri . '"' );
        }
        
        $this->uri = $uri;
    }
    
    public function setHeader( $key, $value )
    {
        $this->headers[ $key ] = $value;
    }

    public function unsetHeader( $key )
    {
        unset( $this->headers[ $key ] );
    }
    
    public function getHeaders()
    {
        return $this->headers;
    }

    public function setHeaders( $headers )
    {
        $this->headers = $headers;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function setMethod( $method )
    {
        $this->method = $method;
    }
    
    public function setParam( $key, $value )
    {
        $this->params[ urlencode( $key ) ] = urlencode( $value );
    }

    public function unsetParam( $key )
    {
        unset( $this->params[ $key ] );
    }
    
    public function getParams()
    {
        return $this->params;
    }

    public function setParams( $headers )
    {
        $this->params = $headers;
    }
}
