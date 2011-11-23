<?php

namespace Insomnia\Kernel\Module\HTTP\Request\Plugin;

use \Insomnia\Request;

/**
 * This test covers all functionality of the HeaderParser plugin
 */
class HeaderParserTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Configure the test
     */
    public function setUp()
    {
        // Create test objects
        $this->request = new Request;
        $this->requestPlugin = new HeaderParser;
        
        // Clear the PHP global which contains the request headers
        $_SERVER = array();
    }
    
    /**
     * Test that the HeaderParser plugin does nothing when do data is present
     */
    public function testDryRun()
    {
        $this->assertEquals( array(), $this->request->getHeaders(), 'Headers should be empty' );
        
        // Run the plugin
        $this->requestPlugin->update( $this->request );
        
        $this->assertEquals( array(), $this->request->getHeaders(), 'Headers should be empty' );
    }
    
    /**
     * Dummy request headers
     *
     * @return array 
     */
    public static function serverGlobalDataprovider()
    {
        return array(
            array( array( 'HTTP_ACCEPT' => 'text/html,application/xhtml+xml' ), array( 'Accept' => 'text/html,application/xhtml+xml' ) ),
            array( array( 'HTTP_HOST' => 'test.com', 'HTTP_USER_AGENT' => 'phpunit' ), array( 'Host' => 'test.com', 'User-Agent' => 'phpunit' ) ),
            array( array( 'REQUEST_METHOD' => 'GET', 'REQUEST_URI' => '/test' ),  array( 'Method' => 'GET', 'Uri' => '/test' ) ),
        );
    }
    
    /**
     * Test that the HeaderParser plugin adds all header information from the
     * $_SERVER superglobal in to the Insomnia request object.
     * 
     * @dataProvider serverGlobalDataprovider
     */
    public function testLoadHeadersFromServerGlobal( $requestHeaders, $expectedHeaders )
    {
        $this->assertEquals( array(), $this->request->getHeaders(), 'Headers should be empty' );
        
        // Load test data in to the $_SERVER superglobal
        $_SERVER = $requestHeaders;
        
        // Run the plugin
        $this->requestPlugin->update( $this->request );
        
        $this->assertEquals( $expectedHeaders, $this->request->getHeaders(), 'Subject should contain all request parameters' );
    }
}
