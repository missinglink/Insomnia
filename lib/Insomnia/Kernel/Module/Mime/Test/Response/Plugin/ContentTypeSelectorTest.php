<?php

namespace Insomnia\Kernel\Module\Mime\Response\Plugin;

use \Insomnia\Registry;
use \Insomnia\Request;
use \Insomnia\Response;

/**
 * This test covers all functionality of the ContentTypeSelector plugin
 */
class ContentTypeSelectorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Configure the test
     */
    public function setUp()
    {
        // Create test objects
        $this->request = new Request;
        Registry::set( 'request', $this->request );
        
        $this->response = new Response;
        $this->contentPlugin = new ContentTypeSelector;
    }
    
    /**
     * Map requested file extension to response content type
     *
     * @return array 
     */
    public static function responseMimeExtensionDataprovider()
    {
        return array(
            array( '.xml',  'application/xml' ),
            array( '.json', 'application/json' ),
            array( '.ini' , 'text/ini'),
            array( '.yaml', 'application/x-yaml' ),
            array( '.txt',  'text/plain' ),
            array( '.html', 'text/html' )
        );
    }
    
    /**
     * Map requested header to reponse content type
     *
     * @return array 
     */
    public static function responseMimeHeaderDataprovider()
    {
        return array(
            array( 'text/xml',   'application/xml' ),
            array( 'text/yaml' , 'application/x-yaml'),
            array( 'application/xhtml', 'text/html' )
        );
    }
    
    /**
     * Test the default mime type is set if none is requested
     */
    public function testDefault()
    {
        $this->contentPlugin->update( $this->response );
        
        $this->assertEquals( ContentTypeSelector::TYPE_JSON, $this->response->getContentType(), 'Default mime type should be JSON' );
    }
    
    /**
     * Test that the ContentTypeSelector plugin detects and returns
     * the requested content type from extension
     * 
     * @dataProvider responseMimeExtensionDataprovider
     */
    public function testMimeFromExtension( $extension, $expectedContent )
    {
        $this->assertEquals( null, $this->request->getContentType(), 'Content type should be empty' );
        
        // Set the request path
        // Need a nicer way to define this...
        $this->request->setParam( 'path', 'path/to/endpoint' . $extension );
        
        // Run the plugin
        $this->contentPlugin->update( $this->response );
        
        $this->assertEquals( $expectedContent, $this->response->getContentType(),
            'Unexpected content type "' . $this->response->getContentType() . '" received for extension "' . $extension . '"' );
    }
    
    /**
     * Test that the ContentTypeSelector plugin detects an
     * invalid content type from extension
     * 
     * Current behavior defines that a default mime is used,
     * but it would preferably throw an exception
     */
    public function testInvalidMimeFromExtension()
    {
        $extension = '.invalid';
        
        // Set the request path
        $this->request->setParam( 'path', 'path/to/endpoint' . $extension );
        
        // Run the plugin
        $this->contentPlugin->update( $this->response );
        
        $this->assertEquals( 'application/json', $this->response->getContentType(),
            'Unexpected content type "' . $this->response->getContentType() . '" received for extension "' . $extension . '"' );
    }
    
    /**
     * Test that the ContentTypeSelector plugin detects and returns
     * the requested content type from headers
     * 
     * @dataProvider responseMimeHeaderDataprovider
     */
    public function testMimeFromHeader( $requestedContent, $expectedContent )
    {
        $this->assertEquals( null, $this->request->getContentType(), 'Content type should be empty' );
        
        // Set the request content header
        $this->request->setHeader( 'Accept', $requestedContent );
        
        // Run the plugin
        $this->contentPlugin->update( $this->response );
        
        $this->assertEquals( $expectedContent, $this->response->getContentType(),
            'Unexpected content type "' . $this->response->getContentType() . '" received for requested type "' . $requestedContent . '"' );
    }
    
    /**
     * Test that the ContentTypeSelector plugin detects an
     * invalid content type from headers
     * 
     * Current behavior defines that a default mime is used,
     * but it would preferably throw an exception
     */
    public function testInvalidMimeFromHeader()
    {
        $requestedContent = 'application/zip';
        
        // Set a request path
        $this->request->setHeader( 'Accept', $requestedContent );
        
        // Run the plugin
        $this->contentPlugin->update( $this->response );
        
        $this->assertEquals( 'application/json', $this->response->getContentType(),
            'Unexpected content type "' . $this->response->getContentType() . '" received for requested type "' . $requestedContent . '"' );
    }
}
