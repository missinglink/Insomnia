<?php

namespace Insomnia\Kernel\Module\HTTP\Request\Plugin;

use \Insomnia\Request;

/**
 * This test covers all functionality of the ParamParser plugin
 */
class UriParserTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Configure the test
     */
    public function setUp()
    {
        // Create test objects
        $this->request = new Request;
        $this->requestPlugin = new UriParser;
        
        // Clear the PHP global which contains the URI
        unset( $_SERVER['REQUEST_URI'] );
    }
    
    /**
     * Test that the UriParser plugin does nothing when do data is present
     */
    public function testDryRun()
    {
        $this->assertEquals( array(), $this->request->getParams(), 'Request should be empty' );
        
        // Run the plugin
        $this->requestPlugin->update( $this->request );
        
        $this->assertEquals( array(), $this->request->getParams(), 'Request should be empty' );
    }
    
    /**
     * Dummy request URI
     *
     * @return array 
     */
    public static function requestUriDataprovider()
    {
        return array(
            array( 'http://www.example.com?test=test', array(
                'scheme' => 'http', 
                'host' => 'www.example.com', 
                'query' => 'test=test'
            )),
            array( 'https://example.com', array(
                'scheme' => 'https', 
                'host' => 'example.com'
            )),
            array( 'ftp://ftp.example.com', array(
                'scheme' => 'ftp', 
                'host' => 'ftp.example.com'
            )),
        );
    }
    
    /**
     * Test that the ParamParser plugin parses $_SERVER['REQUEST_URI'] and adds
     * the resulting information about the URI in to the Insomnia request object.
     * 
     * @dataProvider requestUriDataprovider
     */
    public function testLoadParamsFromRequestUri( $uri, $expectedParams )
    {
        $this->assertEquals( array(), $this->request->getParams(), 'Request should be empty' );
        
        // Load test data in to the $_SERVER superglobal
        $_SERVER['REQUEST_URI'] = $uri;
        
        // Run the plugin
        $this->requestPlugin->update( $this->request );
        
        $this->assertEquals( $expectedParams, $this->request->getParams(), 'Subject should contain all request parameters' );
    }
}
