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
        //$this->getTransport()->attach( new SqliteDebugger );
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
    
    public function assertValidResponse( HTTPResponse $response, $code = Code::HTTP_OK, $contentType = 'application/json', $charset = 'UTF-8' )
    {
        $this->assertEquals( $code, $response->getCode() );
        $this->assertEquals( $contentType, $response->getContentType() );
        $this->assertEquals( $charset, $response->getCharacterSet() );
//        $this->assertLessThan( 1000, $response->getExecutionTime() );
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
//            array( new Browser\Chromium ),
//            array( new Browser\Konqueror ),
//            array( new Browser\Curl ),
//            array( new Browser\BlackBerry ),
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
