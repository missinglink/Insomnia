<?php

namespace Insomnia\Kernel\Module\HTTP\Response\Plugin;

use \Insomnia\Response;

/**
 * This test covers all functionality of the HeaderParser plugin
 */
class CacheHeadersTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Configure the test
     */
    public function setUp()
    {
        // Create test objects
        $this->response = new Response;
        $this->responsePlugin = new CacheHeaders;
    }

    /**
     * Test that the CacheHeaders plugin adds the expected response headers
     * when a Time-To-Live (TTL) has not been specified.
     */
    public function testSetCacheHeadersWithNoTimeToLiveSet()
    {
        $this->assertEquals( array(), $this->response->getHeaders(), 'Headers should be empty' );
        
        // Run the plugin
        $this->responsePlugin->update( $this->response );
        
        $this->assertArrayHasKey( 'Last-Modified', $this->response->getHeaders() );
        $this->assertGreaterThan( strtotime( '-1 seconds' ), strtotime( $this->response->getHeader( 'Last-Modified' ) ) );
        $this->assertLessThanOrEqual( time(), strtotime( $this->response->getHeader( 'Last-Modified' ) ) );
        
        $this->assertArrayHasKey( 'Expires', $this->response->getHeaders() );
        $this->assertEquals( 'Sat, 22 Jan 1983 05:00:00 GMT', $this->response->getHeader( 'Expires' ) );
        
        $this->assertArrayHasKey( 'Cache-Control', $this->response->getHeaders() );
        $this->assertEquals( 'no-store, no-cache, no-transform, must-revalidate, post-check=0, pre-check=0', $this->response->getHeader( 'Cache-Control' ) );
        
        $this->assertArrayHasKey( 'Pragma', $this->response->getHeaders() );
        $this->assertEquals( 'no-cache', $this->response->getHeader( 'Pragma' ) );
    }
    
    /**
     * Test that the CacheHeaders plugin adds the expected response headers
     * when a Time-To-Live (TTL) has been explicitly set.
     */
    public function testSetCacheHeadersWithTimeToLiveSet()
    {
        $this->response->setTimeToLive( 10 );
        
        $this->assertEquals( array(), $this->response->getHeaders(), 'Headers should be empty' );
        
        // Run the plugin
        $this->responsePlugin->update( $this->response );
        
        $this->assertArrayHasKey( 'Last-Modified', $this->response->getHeaders() );
        $this->assertGreaterThan( strtotime( '-1 seconds' ), strtotime( $this->response->getHeader( 'Last-Modified' ) ) );
        $this->assertLessThanOrEqual( time(), strtotime( $this->response->getHeader( 'Last-Modified' ) ) );
        
        $this->assertArrayHasKey( 'Expires', $this->response->getHeaders() );
        $this->assertGreaterThan( strtotime( '+9.5 seconds' ), strtotime( $this->response->getHeader( 'Expires' ) ) );
        $this->assertLessThanOrEqual( strtotime( '+10 seconds' ), strtotime( $this->response->getHeader( 'Expires' ) ) );
        
        $this->assertArrayHasKey( 'Cache-Control', $this->response->getHeaders() );
        $this->assertEquals( 'max-age=10, public', $this->response->getHeader( 'Cache-Control' ) );
    }
}
