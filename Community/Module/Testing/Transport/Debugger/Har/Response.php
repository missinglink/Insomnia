<?php

namespace Community\Module\Testing\Transport\Debugger\Har;

class Response
{
    public $status;
    public $statusText;
    public $httpVersion;
    public $cookies = array();
    public $headers = array();
    public $content;
    public $redirectURL = '';
    public $headersSize = -1;
    public $bodySize = -1;
    
    /**
     * @param integer $status
     * @param string $statusText
     * @param string $httpVersion
     * @throws \UnexpectedValueException 
     */
    public function __construct( $status, $statusText, $httpVersion )
    {        
        if( !is_int( $status ) || !is_string( $statusText ) || !is_string( $httpVersion ) )
        {
            throw new \UnexpectedValueException( 'Precondition Failed' );
        }
        
        $this->status = $status;
        $this->statusText = $statusText;
        $this->httpVersion = $httpVersion;
    }
    
    /**
     * @param Content $content 
     */
    public function setContent( Content $content )
    {
        $this->content = $content;
        $this->bodySize = $content->size;
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
