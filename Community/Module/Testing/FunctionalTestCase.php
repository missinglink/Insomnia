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
    /**
     * Type of transport
     * 
     * @var Transporter
     */
    private $transport;
    
    /**
     * Current debug level, based on CliDebugger constant
     * 
     * @var integer 
     */
    private $debugLevel = CliDebugger::DEBUG_NONE;
    
    /**
     * Only instantiate \PDO once for test clean-up/fixture load
     * 
     * @var \PDO 
     */
    static private $pdo;
    
    /**
     * Only instantiate \PHPUnit_Extensions_Database_DB_IDatabaseConnection once per test
     * 
     * @var \PHPUnit_Extensions_Database_DB_DefaultDatabaseConnection 
     */
    private $conn;
        
 
        
    /**
     * Method to return an array of filepathes to yaml fixture files
     * 
     * @return array
     */
    abstract function loadFixtureData(); 
    
    protected function setUp()
    {
        parent::setUp();
        
        $this->setTransport( new CurlTransport );
        $this->getTransport()->attach( new CliDebugger( $this->debugLevel ) );
        //$this->getTransport()->attach( new SqliteDebugger );
    }

    /**
     * Provides PHPUnit with the needed database connection object
     * (based on the phpunit.xml)
     * 
     * @return \PHPUnit_Extensions_Database_DB_DefaultDatabaseConnection 
     */
    final public function getConnection()
    {
        if ( $this->conn === null )
        {
            if ( self::$pdo == null )
            {
                self::$pdo = new \PDO( $GLOBALS['DB_DSN'], $GLOBALS['DB_USER'], $GLOBALS['DB_PASSWD'] );
            }
            
            $this->conn = $this->createDefaultDBConnection( self::$pdo, $GLOBALS['DB_DBNAME'] );
        }
        
        return $this->conn;
    }
    
    /**
     * Provides PHPUnit with the needed fixture data (yaml based)
     * 
     * @return \PHPUnit_Extensions_Database_DataSet_CompositeDataSet|\PHPUnit_Extensions_Database_DataSet_YamlDataSet
     * @throws \Exception 
     */
    final protected function getDataSet()
    {
        $fixtureData = $this->loadFixtureData();
        
        if ( is_array( $fixtureData ) && 1 < count($fixtureData) )
        {
            $datasets = array();
            
            foreach ( $fixtureData as $fixture )
            {
                if ( !is_readable( $fixture ) )
                {
                    throw new \Exception( 'cannot read from: ' . $fixture );
                }
                $datasets[] = new \PHPUnit_Extensions_Database_DataSet_YamlDataSet( $fixture ); 
            }
            
            return new \PHPUnit_Extensions_Database_DataSet_CompositeDataSet( $datasets );
        }
        elseif (  is_array( $fixtureData ) && 1 === count($fixtureData) )
        {
            if ( !is_readable( $fixtureData[ 0 ] ) )
            {
                throw new \Exception( 'cannot read from: ' . $fixtureData[ 0 ]  );
            }
            
            return new \PHPUnit_Extensions_Database_DataSet_YamlDataSet( $fixtureData[ 0 ] ); 
        }
        else
        {
            throw new \Exception( 'please return an array with at least 1 path in loadFixtureData()' );
        }
    }
    
    protected function transfer( HTTPRequest $request, HTTPResponse $response = null )
    {
        $request->setDomain( 'ws.local.test' );
        
        try
        {
            if( null === $response )
            {
                $response = new HTTPResponse;
            }

            return $this->getTransport()->execute( $request, $response );
        }
        
        catch( \Exception $e )
        {
            $this->markTestSkipped( 'Transport ' . get_class( $this->getTransport() ) . ' failed with message: ' . $e->getMessage() );
        }
    }
    
    public function assertValidResponse( HTTPResponse $response, $code = Code::HTTP_OK, $contentType = 'application/json', $charset = 'UTF-8' )
    {
        $this->assertEquals( $code, $response->getCode() );
        $this->assertEquals( $contentType, $response->getContentType() );
        $this->assertEquals( $charset, $response->getCharacterSet() );
        $this->assertLessThan( 1000, $response->getExecutionTime() );
    }
    
    protected function getSessionId()
    {
        $request = new HTTPRequest( '/session', 'POST' );
        $request->setHeader( 'Accept', 'application/json' );
        $request->setParam( 'email', 'elvis@bravenewtalent.com' );
        $request->setParam( 'password', 'qwerty' );
        
        $response = $this->transfer( $request );
        
        $this->assertValidResponse( $response, Code::HTTP_OK, 'application/json' );
        
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
    
    /**
     * @return integer 
     */
    public function getDebugLevel()
    {
        return $this->debugLevel;
    }

    public function setDebugLevel( $debugLevel )
    {
        $this->debugLevel = $debugLevel;
    }

}
