<?php

namespace Insomnia\Kernel\Module\Mime\Response\Plugin;

use \Insomnia\Request;
use \Insomnia\Response;

/**
 * This test covers all functionality of the ContentTypeSelector plugin
 */
class ParamParserTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Configure the test
     */
    public function setUp()
    {
        // Create test objects
        $this->response = new Request;
        $this->response = new Response;
        $this->contentPlugin = new ContentTypeSelector;
    }
    
    /**
     * Test the default mime type is set if none is requested
     */
    public function testDefault()
    {
        $this->contentPlugin->update($this->response);
        
        $this->assertEquals( ContentTypeSelector::TYPE_JSON, $this->response->getContentType(), 'Default mime type should be JSON' );
    }
    
    /**
     * Request content types
     *
     * @return array 
     */
    public static function responseMimeDataprovider()
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
     * Test that the ParamParser plugin adds all data from the $_REQUEST superglobal
     * in to the Insomnia request object.
     * 
     * @dataProvider responseMimeDataprovider
     */
    public function testMimeFromExtensionGlobal( $extension, $expectedContent )
    {
        $this->assertEquals( null, $this->request->getContentType(), 'Content type should be empty' );
        
        // Set a request path
        // Need a nicer way to define this...
        $this->request->setParam('path', 'path/to/endpoint' . $extension, $expectedContent);
        
        // Run the plugin
        $this->contentPlugin->update( $this->response );
        
        $this->assertEquals( $expectedContent, $this->request->getContentType(),
            'Unexpected content type "' . $this->request->getContentType() . '" received for extension "' . $type . '"' );
    }
}
