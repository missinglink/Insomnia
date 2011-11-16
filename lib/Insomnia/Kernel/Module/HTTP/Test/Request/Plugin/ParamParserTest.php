<?php

namespace Insomnia\Kernel\Module\HTTP\Request\Plugin;

use \Insomnia\Request;

/**
 * This test covers all functionality of the ParamParser plugin
 */
class ParamParserTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Configure the test
     */
    public function setUp()
    {
        // Create test objects
        $this->request = new Request;
        $this->requestPlugin = new ParamParser;
        
        // Default the PHP globals which contain request parameters
        $_REQUEST = array();
        unset( $_SERVER['REQUEST_URI'] );
    }
    
    /**
     * Test that the ParamParser plugin does nothing when do data is present
     */
    public function testDryRun()
    {
        $this->assertEquals( array(), $this->request->getParams(), 'Request should be empty' );
        
        // Run the plugin
        $this->requestPlugin->update( $this->request );
        
        $this->assertEquals( array(), $this->request->getParams(), 'Request should be empty' );
    }
    
    /**
     * Dummy request parameters
     *
     * @return array 
     */
    public static function requestGlobalDataprovider()
    {
        return array(
            array( array(), array() ),
            array( array( 'a' => 0, 2 => '0' ),  array( 'a' => 0, 2 => '0' ) ),
            array( array( 'a' => 1, 'b' => '1' ), array( 'a' => 1, 'b' => '1' ) ),
            array( array( 'a' => '日本国', 'עִבְרִית' => 'b' ), array( 'a' => '日本国', 'עִבְרִית' => 'b' ) ),
            array( array( 'a' => ' ', 'b' => '' ), array() )
        );
    }
    
    /**
     * Test that the ParamParser plugin adds all data from the $_REQUEST superglobal
     * in to the Insomnia request object.
     * 
     * @dataProvider requestGlobalDataprovider
     */
    public function testLoadParamsFromRequestGlobal( $requestParams, $expectedParams )
    {
        $this->assertEquals( array(), $this->request->getParams(), 'Request should be empty' );
        
        // Load test data in to the $_REQUEST superglobal
        $_REQUEST = $requestParams;
        
        // Run the plugin
        $this->requestPlugin->update( $this->request );
        
        $this->assertEquals( $expectedParams, $this->request->getParams(), 'Subject should contain all request parameters' );
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
