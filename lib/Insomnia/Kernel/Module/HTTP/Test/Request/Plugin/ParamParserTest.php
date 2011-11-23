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
        
        // Clear the PHP global which contains the request parameters
        $_REQUEST = array();
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
            array( array( 'a' => ' ', 'b' => '' ), array( 'a' => ' ', 'b' => '' ) ),
            array( array( 'a' => array( 'a', 'b' ), 'c' => array( 'c' => 'd' ) ), array( 'a' => array( 'a', 'b' ), 'c' => array( 'c' => 'd' ) ) ),
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
}
