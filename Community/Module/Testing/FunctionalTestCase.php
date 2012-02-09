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

abstract class FunctionalTestCase extends \PHPUnit_Extensions_Database_TestCase
{
    private $transport;
    
    // only instantiate pdo once for test clean-up/fixture load
    static private $pdo = null;

    // only instantiate PHPUnit_Extensions_Database_DB_IDatabaseConnection once per test
    private $conn = null;
    

    protected function setUp()
    {
        parent::setUp();
        
        $this->setTransport( new CurlTransport );
        $this->getTransport()->attach( new CliDebugger( CliDebugger::DEBUG_VERBOSE ) );
        //$this->getTransport()->attach( new SqliteDebugger );
    }

    final public function getConnection()
    {
        if ($this->conn === null)
        {
            if (self::$pdo == null)
            {
                self::$pdo = new \PDO( $GLOBALS['DB_DSN'], $GLOBALS['DB_USER'], $GLOBALS['DB_PASSWD'] );
            }
            
            $this->conn = $this->createDefaultDBConnection( self::$pdo, $GLOBALS['DB_DBNAME'] );
        }

        return $this->conn;
    }
    
    protected function transfer( HTTPRequest $request, HTTPResponse $response = null )
    {
        $request->setDomain( 'ws.local.test' );
        
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
    
    protected function getSessionId()
    {
        $request = new HTTPRequest( '/session', 'POST' );
        $request->setHeader( 'Accept', 'application/json' );
        $request->setParam( 'email', 'elvis@bravenewtalent.com' );
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
//            array( new Browser\Chromium_v14_0 ),
//            array( new Browser\Konqueror_v4_5_5 ),
////            array( new Browser\Curl_v7_21 ),
//            array( new Browser\BlackBerry_6 ),
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
