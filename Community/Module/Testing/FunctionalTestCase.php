<?php

namespace Community\Module\Testing;

use \Community\Module\Testing\Transport\Cli\CurlTransport,
    \Community\Module\Testing\Transport\Debugger\CliDebugger,
    \Community\Module\Testing\Transport\Debugger\SqliteDebugger,
    \Community\Module\Testing\Transport\Transporter,
    \Community\Module\Testing\Transport\Browser,
    \Community\Module\Testing\Transport\HTTPRequest,
    \Community\Module\Testing\Transport\HTTPResponse;

use \Insomnia\Response\Code;

class FunctionalTestCase extends \PHPUnit_Framework_TestCase
{
    private $transport;
    
    protected function setUp()
    {
        $this->setTransport( new CurlTransport );
        $this->getTransport()->attach( new CliDebugger( CliDebugger::DEBUG_VERBOSE ) );
        //$this->getTransport()->attach( new SqliteDebugger );
    }
    
    protected function transfer( HTTPRequest $request, HTTPResponse $response = null )
    {
        $request->setDomain( 'ws.local.bnt' );
        
        if( null === $response )
        {
            $response = new HTTPResponse;
        }
        
        return $this->getTransport()->execute( $request, $response );
    }
    
    public function assertValidResponse( HTTPResponse $response, $code = Code::HTTP_OK, $contentType = 'application/json', $charset = 'UTF-8' )
    {
        $this->assertEquals( $code, $response->getCode() );
        $this->assertEquals( $contentType, $response->getContentType() );
        $this->assertEquals( $charset, $response->getCharacterSet() );
        $this->assertLessThan( 500, $response->getExecutionTime() );
    }
    
    public function testNothing()
    {
        
    }
    
    protected function getSessionId()
    {
        $request = new HTTPRequest( '/session', 'POST' );
        $request->setHeader( 'Accept', 'application/json' );
        $request->setParam( 'email', 'peter@bravenewtalent.com' );
        $request->setParam( 'password', 'qwerty' );
        
        $response = $this->transfer( $request );
        
        $this->assertEquals( Code::HTTP_OK, $response->getCode() );
        $this->assertEquals( 'application/json', $response->getContentType() );
        $this->assertEquals( 'UTF-8', $response->getCharacterSet() );
        $this->assertLessThan( 500, $response->getExecutionTime() );
        
        $json = json_decode( $response->getBody(), true );
        $this->assertArrayHasKey( 'sessionId', $json );
        
        return (string) $json[ 'sessionId' ];
    }
    
    /**
     * Load a list of browsers to test against
     * 
     * @return array 
     */
    public static function getBrowserTemplates()
    {
        return array(
            array( new Browser\Firefox_v8_0 ),
            array( new Browser\Chromium_v14_0 ),
            array( new Browser\Konqueror_v4_5_5 ),
//            array( new Browser\Curl_v7_21 ),
            array( new Browser\BlackBerry_6 ),
        );
    }

    /**
     *
     * @return Transporter 
     */
    protected function getTransport()
    {
        return $this->transport;
    }

    protected function setTransport( Transporter $transport )
    {
        $this->transport = $transport;
    }
}
