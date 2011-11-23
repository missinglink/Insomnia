<?php

namespace Insomnia\Kernel\Module\Mime\Response\Plugin;

use \Insomnia\Response,
    \Insomnia\Kernel\Module\Mime\Response\Content,
    \Insomnia\Kernel\Module\Mime\Response\Renderer;

/**
 * This test covers all functionality of the RendererSelector plugin
 */
class RendererSelectorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Configure the test
     */
    public function setUp()
    {
        // Create test objects
        $this->response = new Response;
        $this->rendererPlugin = new RendererSelector;
    }
    
    /**
     * Map requested file extension to response content type
     *
     * @return array 
     */
    public static function responseMimeExtensionDataprovider()
    {
        return array(
            array( Content::TYPE_XML,       'Insomnia\Kernel\Module\Mime\Response\Renderer\XmlRenderer' ),
            array( Content::TYPE_XML_TEXT,  'Insomnia\Kernel\Module\Mime\Response\Renderer\XmlRenderer' ),
            array( Content::TYPE_JSON,      'Insomnia\Kernel\Module\Mime\Response\Renderer\JsonRenderer' ),
            array( Content::TYPE_INI,       'Insomnia\Kernel\Module\Mime\Response\Renderer\IniRenderer' ),
            array( Content::TYPE_YAML,      'Insomnia\Kernel\Module\Mime\Response\Renderer\YamlRenderer' ),
            array( Content::TYPE_YAML_TEXT, 'Insomnia\Kernel\Module\Mime\Response\Renderer\YamlRenderer' ),
            array( Content::TYPE_PLAIN,     'Insomnia\Kernel\Module\Mime\Response\Renderer\ArrayRenderer' ),
            array( Content::TYPE_HTML,      'Insomnia\Kernel\Module\Mime\Response\Renderer\ViewRenderer' ),
            
            // Default renderer for invalid content type
            array( 'application/zip',                   'Insomnia\Kernel\Module\Mime\Response\Renderer\JsonRenderer' )
        );
    }
    
    /**
     * Test the default mime type is set if none is requested
     */
    public function testDefault()
    {
        $this->rendererPlugin->update( $this->response );
        
        $this->assertTrue( $this->response->getRenderer() instanceof Renderer\JsonRenderer, 'Default content renderer should be JsonRenderer' );
    }
    
    /**
     * Test that the ContentTypeSelector plugin detects and returns
     * the requested content type from extension
     * 
     * @dataProvider responseMimeExtensionDataprovider
     */
    public function testRendererInstance( $content, $class )
    {
        $this->assertEquals( null, $this->response->getRenderer(), 'Renderer instance should not be defined' );
        
        // Set the content type
        $this->response->setContentType( $content );
        
        // Run the plugin
        $this->rendererPlugin->update( $this->response );
        
        $this->assertTrue( $this->response->getRenderer() instanceof $class,
            'Unexpected renderer class "' . get_class($this->response->getRenderer()) . '" for content type "' . $content . '"' );
    }
}
