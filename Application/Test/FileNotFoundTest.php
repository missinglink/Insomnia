<?php

namespace Application\Test;

use \Community\Module\Testing\FunctionalTestCase,
    \Community\Module\Testing\Transport\HTTPRequest,
    \Community\Module\Testing\Transport\HTTPResponse,
    \Insomnia\Response\Code;

/**
 * @group functional
 */
class FileNotFoundTest extends FunctionalTestCase
{
    /**
     * @dataProvider getBrowserTemplates
     * 
     * @param HTTPRequest $browserTemplate
     */   
    public function testFileNotFound_Json( $browserTemplate )
    {
        $request = new HTTPRequest( '/invalid/url' );
        $request->setHeaders( $browserTemplate->getHeaders() );
        $request->setHeader( 'Accept', 'application/json' );
        
        $response = $this->transfer( $request );
        
        $this->assertEquals( Code::HTTP_NOT_FOUND, $response->getCode() );
        $this->assertEquals( 'application/json', $response->getContentType() );
        $this->assertEquals( 'UTF-8', $response->getCharacterSet() );
        $this->assertLessThan( 250, $response->getExecutionTime() );
        
        $json = json_decode( $response->getBody(), true );
        
        $this->assertEquals( '404 Not Found', $json[ 'status' ] );
        $this->assertEquals( 'Resource Not Found', $json[ 'title' ] );
        $this->assertEquals( 'The requested resource could not be found but may be available again in the future', $json[ 'body' ] );
    }
    
    /**
     * @dataProvider getBrowserTemplates
     * 
     * @param HTTPRequest $browserTemplate
     */   
    public function testFileNotFound_Xml( $browserTemplate )
    {
        $request = new HTTPRequest( '/invalid/url' );
        $request->setHeaders( $browserTemplate->getHeaders() );
        $request->setHeader( 'Accept', 'application/xml' );
        
        $response = $this->transfer( $request );
        
        $this->assertEquals( Code::HTTP_NOT_FOUND, $response->getCode() );
        $this->assertEquals( 'application/xml', $response->getContentType() );
        $this->assertEquals( 'UTF-8', $response->getCharacterSet() );
        $this->assertLessThan( 250, $response->getExecutionTime() );
        
        $xml = new \SimpleXMLElement( $response->getBody() );
        
        $this->assertEquals( '404 Not Found', (string) $xml->status );
        $this->assertEquals( 'Resource Not Found', (string) $xml->title );
        $this->assertEquals( 'The requested resource could not be found but may be available again in the future', (string) $xml->body );
    }
    
    /**
     * @dataProvider getBrowserTemplates
     * 
     * @param HTTPRequest $browserTemplate
     */   
    public function testFileNotFound_Default( $browserTemplate )
    {
        $request = new HTTPRequest( '/invalid/url' );
        $request->setHeaders( $browserTemplate->getHeaders() );
        
        $response = $this->transfer( $request );
        
        $this->assertEquals( Code::HTTP_NOT_FOUND, $response->getCode() );
        $this->assertEquals( 'text/html', $response->getContentType() );
        $this->assertEquals( 'UTF-8', $response->getCharacterSet() );
        $this->assertLessThan( 250, $response->getExecutionTime() );
        
        $this->assertContains( '404 Not Found', $response->getBody() );
        $this->assertContains( 'Resource Not Found', $response->getBody() );
        $this->assertContains( 'The requested resource could not be found but may be available again in the future', $response->getBody() );
    }
}
