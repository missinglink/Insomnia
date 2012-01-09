<?php

namespace Community\Module\Testing\Transport;

class HTTPResponse
{
    private $body = '';
    private $code = 0;
    private $executionTime = 0;
    private $protocol = '';
    private $headers = array();
    
    public function getBody()
    {
        return $this->body;
    }

    public function setBody( $body )
    {
        $this->body = $body;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function setCode( $code )
    {
        $this->code = $code;
    }
    
    public function getExecutionTime()
    {
        return $this->executionTime;
    }

    public function setExecutionTime( $executionTime )
    {
        $this->executionTime = $executionTime;
    }

    public function getProtocol()
    {
        return $this->protocol;
    }

    public function setProtocol( $protocol )
    {
        $this->protocol = $protocol;
    }

    public function getHeaders()
    {
        return $this->headers;
    }
    
    public function getHeader( $key )
    {
        return isset( $this->headers[ $key ] ) ? $this->headers[ $key ] : null;
    }

    public function setHeaders( $headers )
    {
        $this->headers = $headers;
    }
    
    public function setHeader( $key, $value )
    {
        $this->headers[ $key ] = $value;
    }
    
    public function unsetHeader( $key )
    {
        unset( $this->headers[ $key ] );
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
     * Get HTTP charset
     *
     * @return string Character set
     */
    public function getCharacterSet()
    {
        return trim( strstr( $this->getHeader( 'Content-Type' ), '='), '= ' );
    }
}
