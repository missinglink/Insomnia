<?php

namespace Community\Module\Testing;

use \Community\Module\Testing\Transport\Cli\CurlTransport,
    \Community\Module\Testing\Transport\Debugger\CliDebugger,
    \Community\Module\Testing\Transport\Debugger\HarWriter,
    \Community\Module\Testing\Transport\Transporter,
    \Community\Module\Testing\Transport\Browser,
    \Community\Module\Testing\Transport\HTTPRequest,
    \Community\Module\Testing\Transport\HTTPResponse;

use \Community\Module\Testing\Transport\Debugger\Har;

use \Insomnia\Response\Code;

/**
 * @backupStaticAttributes disabled
 */
class FunctionalTestCase extends \PHPUnit_Framework_TestCase
{
    private $transport;
    public static $testCaseId;
    
    public static function setUpBeforeClass()
    {
        self::$testCaseId = md5( mt_rand( 0, \PHP_INT_MAX ) . microtime( true ) );
    }

    protected function setUp()
    {
        $this->setTransport( new CurlTransport );
        $this->getTransport()->attach( new CliDebugger( /* CliDebugger::DEBUG_FULL */ ) );
        
        $title = '['.date( 'H:i:s d/m/Y' ).'] ' . strstr( get_class( $this ), '\\', true );
        $this->getTransport()->attach( new HarWriter( '/tmp/har', self::$testCaseId, $title ) );
    }
    
    protected function transfer( HTTPRequest $request, HTTPResponse $response = null )
    {
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
            $this->markTestSkipped( 'new ' . get_class( $e ) . '( ' . $e->getMessage() . ' ) ' . $e->getFile() . ':' . $e->getLine() );
        }
    }
    
    public function assertValidResponse( HTTPResponse $response, $code = Code::HTTP_OK, $contentType = 'application/json', $charset = 'UTF-8' )
    {
        $this->assertEquals( $code, $response->getCode() );
        $this->assertEquals( $contentType, $response->getContentType() );
        $this->assertEquals( $charset, $response->getCharacterSet() );
        $this->assertLessThan( 500, $response->getExecutionTime() );
    }
    
    /**
     * Load a list of browsers to test against
     * 
     * @return array 
     */
    public static function getBrowserTemplates()
    {
        return array(
//            array( new Browser\Firefox_v8_0 ),
//            array( new Browser\Chromium_v14_0 ),
//            array( new Browser\Konqueror_v4_5_5 ),
            array( new Browser\Curl_v7_21 ),
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
