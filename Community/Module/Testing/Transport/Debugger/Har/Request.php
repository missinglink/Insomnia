<?php

namespace Community\Module\Testing\Transport\Debugger\Har;

class Request
{
    public $method;
    public $url;
    public $httpVersion;
    public $cookies = array();
    public $headers = array();
    public $queryString = array();
    public $headersSize = 0;
    public $bodySize = -1;    
    
    /**
     * @param string $method
     * @param string $url
     * @param string $httpVersion
     * @throws \UnexpectedValueException 
     */
    public function __construct( $method, $url, $httpVersion )
    {
        if( !is_string( $method ) || !is_string( $url ) || !is_string( $httpVersion ) )
        {
            throw new \UnexpectedValueException( 'Precondition Failed' );
        }
        
        $this->method = $method;
        $this->url = $url;
        $this->httpVersion = $httpVersion;
    }
    
    /**
     * @param Param $param 
     */
    public function addParam( Param $param )
    {
        $this->queryString[] = $param;
    }
    
    /**
     * @param Header $header 
     */
    public function addHeader( Header $header )
    {
        $this->headers[] = $header;
        $this->headersSize = $this->getHeaderSize();
    }
    
    /**
     * @return integer 
     */
    private function getHeaderSize()
    {
        $size = 0;
        
        /* @var $header HarHeader */
        foreach( $this->headers as $header )
        {
            $size += $header->getSize();
        }
        
        return (int) $size;
    }
}
