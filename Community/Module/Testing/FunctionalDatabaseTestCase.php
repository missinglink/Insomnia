<?php

namespace Community\Module\Testing;

use \Community\Module\Testing\Transport\Cli\CurlTransport,
    \Community\Module\Testing\Transport\Debugger\CliDebugger,
    \Community\Module\Testing\Transport\Transporter,
    \Community\Module\Testing\Transport\Browser,
    \Community\Module\Testing\Transport\HTTPRequest,
    \Community\Module\Testing\Transport\HTTPResponse;

abstract class FunctionalDatabaseTestCase extends \PHPUnit_Extensions_Database_TestCase
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
     * Cached yaml fixtures
     * 
     * @var array
     */
    private static $fixtureCache = array();
        
    /**
     * Method to return an array of filepathes to yaml fixture files
     * 
     * @return array
     */
    abstract function loadFixtureData(); 
    
    protected function setUp()
    {
        global $argv;
        if( isset( $argv ) )
        {
            if( in_array( '--debug', $argv ) )
            {
                $this->setDebugLevel( CliDebugger::DEBUG_VERBOSE );
            }
            
            elseif( in_array( '--verbose', $argv ) || in_array( '-v', $argv ) )
            {
                $this->setDebugLevel( CliDebugger::DEBUG_SIMPLE );
            }
        }
        
        parent::setUp();
        
        $this->setTransport( new CurlTransport );
        $this->getTransport()->attach( new CliDebugger( $this->debugLevel ) );
    }
    
    protected function transfer( HTTPRequest $request, HTTPResponse $response = null, $followRedirects = true )
    {
        try
        {
            if( null === $response )
            {
                $response = new HTTPResponse;
            }
            
            $this->getTransport()->followRedirects( (bool) $followRedirects );

            return $this->getTransport()->execute( $request, $response );
        }
        
        catch( \Exception $e )
        {
            $this->markTestSkipped( 'Transport ' . get_class( $this->getTransport() ) . ' failed with message: ' . $e->getMessage() );
        }
    }
    
    protected function assertValidResponse( HTTPResponse $response, $code = Code::HTTP_OK, $contentType = 'application/json', $charset = 'UTF-8' )
    {
        $this->assertEquals( $code, $response->getCode() );
        $this->assertEquals( $contentType, $response->getContentType() );
        $this->assertEquals( $charset, $response->getCharacterSet() );
    }
    
    /**
     * Load a list of browsers to test against
     * 
     * @return array 
     */
    public static function getBrowserTemplates()
    {
        return array(
            array( new Browser\Firefox ),
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
    protected function getDebugLevel()
    {
        return $this->debugLevel;
    }

    protected function setDebugLevel( $debugLevel )
    {
        $this->debugLevel = $debugLevel;
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
        $fixtureHash = md5( serialize( $fixtureData ) );
        
        if (! empty( self::$fixtureCache[$fixtureHash] ) )
        {
            return self::$fixtureCache[$fixtureHash];
        }
        
        if ( is_array( $fixtureData ) && 1 < count( $fixtureData ) )
        {
            $dataset = new \PHPUnit_Extensions_Database_DataSet_YamlDataSet( $fixtureData[ 0 ] );
            
            for( $x=1; $x<count($fixtureData); $x++ )
            {
                if ( !is_readable( $fixtureData[ $x ] ) )
                {
                    throw new \Exception( 'cannot read from: ' . $fixtureData[ $x ] );
                }
                
                $dataset->addYamlFile( $fixtureData[ $x ] );
            }
        }
        
        elseif ( is_array( $fixtureData ) && 1 === count($fixtureData) )
        {
            if ( !is_readable( $fixtureData[ 0 ] ) )
            {
                throw new \Exception( 'cannot read from: ' . $fixtureData[ 0 ] );
            }
            $dataset = new \PHPUnit_Extensions_Database_DataSet_YamlDataSet( $fixtureData[ 0 ] ); 
        }
        
        else
        {
            throw new \Exception( 'please return an array with at least 1 path in loadFixtureData()' );
        }
        
        return self::$fixtureCache[$fixtureHash] = $dataset;
    }
}