<?php

namespace Community\Module\RequestValidator\Request;

use Community\Module\RequestValidator\Request\InputSanitiser;

/**
 * This test covers all functionality of the InputSanitiser class
 */
class InputSanitiserTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers Community\Module\RequestValidator\Request\InputSanitiser::stripTags
     */
    public function testStripTags()
    {
        $input = '<script type="text/javascript">alert("test");</script>';
        
        $sanitiser = new InputSanitiser( $input );
        $sanitiser->stripTags();
        
        $this->assertEquals( 'alert("test");', $sanitiser->getValue() );
    }
    
    /**
     * @covers Community\Module\RequestValidator\Request\InputSanitiser::stripTags
     */
    public function testStripTags_LotsOfTags()
    {
        $input = '<a><a><b>Bold</b><h1>Title</h1></a></a>';
        
        $sanitiser = new InputSanitiser( $input );
        $sanitiser->stripTags();
        
        $this->assertEquals( 'BoldTitle', $sanitiser->getValue() );
    }

    /**
     * @covers Community\Module\RequestValidator\Request\InputSanitiser::removeTagBody
     * @todo Implement testRemoveTagBody().
     */
    public function testRemoveTagBody()
    {
        $input = '<script type="text/javascript">alert("test");</script><style>.alert{text-decoration:blink;}</style>';
        
        $sanitiser = new InputSanitiser( $input );
        $sanitiser->removeTagBody( 'script' )
                  ->removeTagBody( 'style' );

        $this->assertEquals( '', $sanitiser->getValue() );
    }
    
    /**
     * @covers Community\Module\RequestValidator\Request\InputSanitiser::removeTagBody
     * @todo Implement testRemoveTagBody().
     */
    public function testRemoveTagBody2()
    {
        $input = '<script type="text/javascript">alert("test");</script><style>.alert{text-decoration:blink;}</style>';
        
        $sanitiser = new InputSanitiser( $input );
        $sanitiser->removeTagBody( 'script' );

        $this->assertEquals( '<style>.alert{text-decoration:blink;}</style>', $sanitiser->getValue() );
    }
    
    /**
     * @covers Community\Module\RequestValidator\Request\InputSanitiser::removeTagBody
     * @todo Implement testRemoveTagBody().
     */
    public function testRemoveTagBody3()
    {
        $input = '<script type="text/javascript">alert("test");</script><style>.alert{text-decoration:blink;}</style>';
        
        $sanitiser = new InputSanitiser( $input );
        $sanitiser->removeTagBody( 'style' );

        $this->assertEquals( '<script type="text/javascript">alert("test");</script>', $sanitiser->getValue() );
    }

    /**
     * @covers Community\Module\RequestValidator\Request\InputSanitiser::getValue
     * @todo Implement testGetValue().
     */
    public function testGetValue()
    {
        $input = '<script type="text/javascript">alert("test");</script>';
        
        $sanitiser = new InputSanitiser( $input );

        $this->assertEquals( $input, $sanitiser->getValue() );
    }
}

?>
