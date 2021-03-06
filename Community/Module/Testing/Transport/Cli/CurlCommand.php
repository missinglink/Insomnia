<?php

namespace Community\Module\Testing\Transport\Cli;

use \Community\Module\Testing\Transport\HTTPRequest;

class CurlCommand
{
    public static $followRedirects = true;
    
    private $command = '';
    private $stdout = '';
    private $exitCode = 0;
    private $outputFilePath = '';
    private $executionTime = 0;
    
    private $requestHeaders;
    private $responseHeaders;
    private $responseBody;
    
    public function __construct()
    {
        // Check Curl binary installed correctly
        if( !exec( 'which curl 2>&1' ) )
        {
            throw new \Exception( 'Curl binary not found. Install curl binary package to run tests.' );
        }
    }
       
    public function execute( HTTPRequest $request )
    {
        $this->prepare( $request );
        $this->exec();

        switch( $this->getExitCode() )
        {
            case 0 :
                $this->setRequestHeaders( preg_replace( '_^> _', '', preg_grep( '_^> (.*)$_', $this->getStdout() ) ) );
                $this->setResponseHeaders( preg_replace( '_^< _', '', preg_grep( '_^< (.*)$_', $this->getStdout() ) ) );
                break;
            
            default :
                throw new \Exception( 'Failed to execute command: ' . $this->getCommand() );
        }
    }
    
    private function prepare( HTTPRequest $request )
    {        
        // Setup Command
        $cmd = array( 'curl -vs' );
        
        if( true === self::$followRedirects )
        {
            $cmd[] = '-L';
        }
      
        // Create Output File
        $this->setOutputFilePath( tempnam( sys_get_temp_dir(), 'curl_' ) );
        
        // Set Output File
        $cmd[] = '-o ' . $this->getOutputFilePath();
        
        // Add Method
        $cmd[] = '-X ' . $request->getMethod();
        
        // Add Request Headers
        foreach( $request->getHeaders() as $headerKey => $headerValue )
        {
            $cmd[] = '-H "' . $headerKey . ': ' . $headerValue . '"';
        }
        
        // Treat Request Params as a GET
        if( in_array( $request->getMethod(), array( 'GET', 'HEAD' ) ) )
        {
            $cmd[] = '-G';
        }
        
        // Add Request Params
        foreach( $request->getParams() as $paramKey => $paramValue )
        {
            $cmd[] = '-d "' . $paramKey . '=' . $paramValue . '"';
        }
       
        // Add URI
        $cmd[] = $request->getProtocol() . '://' . $request->getDomain() . $request->getUri();
        
        // Set Command
        $this->setCommand( implode( ' ', $cmd ) . ' 2>&1' );
    }
    
    private function exec()
    {
        // Start Timer
        $timer = microtime( true );
        
        // Execute Command
        exec( $this->getCommand(), $this->stdout, $this->exitCode );
        
        // Set Execution Time
        $this->setExecutionTime( microtime( true ) - $timer );
        
        // Get Response Body
        $responseBody = file_get_contents( $this->getOutputFilePath() );
                
        // Delete Output File
        @unlink( $this->getOutputFilePath() );
        
        // Decode Gzipped Content
        if( stripos( implode( \PHP_EOL, $this->stdout ), 'Content-Encoding: gzip' ) )
        {
            $responseBody = gzinflate( substr( $responseBody, 10 ) );
        }
        
        // Set Response Body
        $this->setResponseBody( $responseBody );
    }
    
    /**
     * @param boolean $followRedirects 
     */
    public function followRedirects( $followRedirects )
    {
        self::$followRedirects = (bool) $followRedirects;
    }
    
    public function getCommand()
    {
        return $this->command;
    }

    public function setCommand( $command )
    {
        $this->command = $command;
    }
    
    public function getStdout()
    {
        return $this->stdout;
    }

    public function setStdout( $stdout )
    {
        $this->stdout = $stdout;
    }
    
    public function getExitCode()
    {
        return $this->exitCode;
    }

    public function setExitCode( $exitCode )
    {
        $this->exitCode = $exitCode;
    }
    
    public function getOutputFilePath()
    {
        return $this->outputFilePath;
    }

    public function setOutputFilePath( $outputFilePath )
    {
        $this->outputFilePath = $outputFilePath;
    }
    
    public function getExecutionTime()
    {
        return $this->executionTime;
    }

    public function setExecutionTime( $executionTime )
    {
        $this->executionTime = $executionTime;
    }
    
    public function getRequestHeaders()
    {
        return $this->requestHeaders;
    }

    public function setRequestHeaders( $requestHeaders )
    {
        $this->requestHeaders = $requestHeaders;
    }

    public function getResponseHeaders()
    {
        return $this->responseHeaders;
    }

    public function setResponseHeaders( $responseHeaders )
    {
        $this->responseHeaders = $responseHeaders;
    }

    public function getResponseBody()
    {
        return $this->responseBody;
    }

    public function setResponseBody( $responseBody )
    {
        $this->responseBody = trim( $responseBody );
    }
}
