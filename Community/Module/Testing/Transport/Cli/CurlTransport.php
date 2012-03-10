<?php

namespace Community\Module\Testing\Transport\Cli;

use \Insomnia\Pattern\Subject;
use \Community\Module\Testing\Transport\Transporter;
use \Community\Module\Testing\Transport\Cli\CurlCommand;
use \Community\Module\Testing\Transport\HTTPRequest;
use \Community\Module\Testing\Transport\HTTPResponse;

class CurlTransport extends Subject implements Transporter
{
    const FOLLOW_REDIRECTS = true;
    
    private $request;
    private $response;
    private $stats;
    
    public function execute( HTTPRequest $request, HTTPResponse $response )
    {
        $this->setRequest( $request );
        $this->setResponse( $response );
        
        $cli = new CurlCommand;
        $cli->execute( $request );
        
        $this->setStats( $cli->getStats() );
        
        // Request Headers
        $requestHeaders = $cli->getRequestHeaders();
        
        // Parse Request Message
        if( !preg_match( '/^(?<method>[A-Z]*)\s+(?<uri>.*)\s+(?<protocol>.*)$/', array_shift( $requestHeaders ), $requestMessage ) )
        {
            throw new \Exception( 'Invalid Request Header' );
        }
        
        // Set Request Message
        $request->setMethod( $requestMessage[ 'method' ] );
        $request->setUri( $requestMessage[ 'uri' ] );
        $request->setProtocol( $requestMessage[ 'protocol' ] );

        // Set Request Headers
        foreach( $requestHeaders as $header )
        {
            if( preg_match( '/^(?<key>[^:]*):\s+(?<value>.*)$/', $header, $headerPair ) )
            {
                $request->setHeader( $headerPair[ 'key' ], $headerPair[ 'value' ] );
            }
        }
        
        // Response Object
        $responseHeaders = $cli->getResponseHeaders();
        
        // Parse Response Message
        if( !preg_match( '/^(?<protocol>HTTP\/\d\.\d)\s+(?<code>.*)$/', array_shift( $responseHeaders ), $responseMessage ) )
        {
            throw new \Exception( 'Invalid Response Header' );
        }
        
        // Set Response Message
        $response->setProtocol( $responseMessage[ 'protocol' ] );
        $response->setCode( $responseMessage[ 'code' ] );

        // Set Response Headers
        foreach( $responseHeaders as $header )
        {
            if( preg_match( '/^(?<key>[^:]*):\s+(?<value>.*)$/', $header, $headerPair ) )
            {
                $response->setHeader( $headerPair[ 'key' ], $headerPair[ 'value' ] );
            }
        }
        
        // Response Body
        $response->setBody( $cli->getResponseBody() );
        
        // Response Time
        $response->setExecutionTime( $cli->getExecutionTime() * 1000 );
        
        // Notify Observers
        $this->notify();
        
        // Return Response Object
        return $response;
    }
    
    public function getRequest()
    {
        return $this->request;
    }

    public function setRequest( $request )
    {
        $this->request = $request;
    }

    public function getResponse()
    {
        return $this->response;
    }

    public function setResponse( $response )
    {
        $this->response = $response;
    }
    
    public function getStats()
    {
        return $this->stats;
    }

    public function setStats( $stats )
    {
        $this->stats = $stats;
    }
}
