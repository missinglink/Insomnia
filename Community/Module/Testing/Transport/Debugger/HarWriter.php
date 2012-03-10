<?php

namespace Community\Module\Testing\Transport\Debugger;

use \Insomnia\Pattern\Observer;
use \Community\Module\Testing\Transport\Debugger\Har;

use \Community\Module\Testing\Transport\HTTPRequest;
use \Community\Module\Testing\Transport\HTTPResponse;

class HarWriter extends Observer
{
    private $logDir;
    
    /**
     * @param string $logDir
     * @param string $testCaseId
     * @param string $title
     * @throws \UnexpectedValueException
     * @throws \Exception 
     */
    public function __construct( $logDir, $testCaseId, $title )
    {
        $logDir = realpath( $logDir );
        
        if( !is_string( $logDir ) || !is_dir( $logDir ) || !is_writable( $logDir ) )
        {
            throw new \UnexpectedValueException( 'Precondition Failed' );
        }
        
        if( !is_string( $testCaseId ) || !is_string( $title ) )
        {
            throw new \UnexpectedValueException( 'Precondition Failed' );
        }
        
        $testCasePath = $logDir . \DIRECTORY_SEPARATOR . $testCaseId;
        if( !( $testCaseDir = realpath( $testCasePath ) ) )
        {
            if( !mkdir( $testCasePath, 0777 ) )
            {
                throw new \Exception( 'Could not create directory' );
            }
        }
        
        $this->logDir = $testCaseDir . \DIRECTORY_SEPARATOR;
        $this->title = $title;
    }
    
    /* @var $transaction Transporter */
    public function update( \SplSubject $transport )
    {
        // Create HAR log
        $log = new Har\Log(
            new Har\Creator( __CLASS__, '1' ), 
            new Har\Browser( 'Insomnia Functional Testing Module', '1' )
        );
        
        $timings = new Har\Timings( $transport->getStats() );
        
        // Create HAR page
        $page = new Har\Page( $this->title, new Har\PageTimings( 0, 0 ) );
        $log->addPage( $page );
        
        // Map request & response
        $request = $this->mapRequest( $transport->getRequest() );
        $response = $this->mapResponse( $transport->getResponse() );
        
        // Create HAR entry
        //$httpExecutionTime = (int) $transport->getResponse()->getExecutionTime();
        $entry = new Har\Entry( $page, (int) $timings->getTotal(), $request, $response, new Har\Cache, $timings );
        $log->addEntry( $entry );
          
//        $page->pageTimings->onContentLoad += $httpExecutionTime;
        $page->pageTimings->onLoad += (int) $timings->getTotal();
        
        // Json encode
        $json = json_encode( new Har\File( $log ) );
        
        // Debug
//        var_dump( $json );
        
        // Log
        $logFile = $this->logDir . ( microtime( true ) * 10000 ) . '-' . mt_rand( 10000, 99999 ) . '.json';
        file_put_contents( $logFile, $json );
    }
    
    /**
     * @param HTTPRequest $httpRequest
     * @return Har\Request 
     */
    private function mapRequest( HTTPRequest $httpRequest )
    {
        // Create a new request
        $request = new Har\Request( $httpRequest->getMethod(), $httpRequest->getUri(), $httpRequest->getProtocol() );
        
        // Map Headers
        foreach( $httpRequest->getHeaders() as $headerKey => $headerValue )
        {
            $request->addHeader( new Har\Header( (string) $headerKey, (string) $headerValue ) );
        }
        
        // Map Params
        foreach( $httpRequest->getParams() as $paramKey => $paramValue )
        {
            $request->addParam( new Har\Param( (string) $paramKey, (string) $paramValue ) );
        }
        
        return $request;
    }
    
    /**
     * @param HTTPResponse $httpResponse
     * @return Har\Response 
     */
    private function mapResponse( HTTPResponse $httpResponse )
    {
        // Split response status header
        if( !preg_match( '_^(?P<code>[0-9]{3}) (?P<title>.*)$_', $httpResponse->getCode(), $httpStatus ) )
        {
            throw new \Exception( 'regex fail' );
        }

        // Create a new response
        $response = new Har\Response( (int) $httpStatus[ 'code' ], (string) $httpStatus[ 'title' ], (string) $httpResponse->getProtocol() );
        
        // Map Headers
        foreach( $httpResponse->getHeaders() as $headerKey => $headerValue )
        {
            $response->addHeader( new Har\Header( (string) $headerKey, (string) $headerValue ) );
        }
        
        // Map Content
        if( strlen( $httpResponse->getBody() ) )
        {
            $contentTypeHeader = $httpResponse->getHeader( 'Content-Type' );
            $response->setContent(
                new Har\Content(
                    is_string( $contentTypeHeader ) ? $contentTypeHeader : 'application/unknown',
                    $httpResponse->getBody()
                )
            );
        }
        
        return $response;
    }
}
