<?php

namespace Application\Test;

use \Community\Module\Testing\FunctionalTestCase,
    \Community\Module\Testing\Transport\HTTPRequest,
    \Community\Module\Testing\Transport\HTTPResponse,
    \Insomnia\Response\Code;

/**
 * @group functional
 */
class JsonRequestTest extends FunctionalTestCase
{
    /**
     * @dataProvider getBrowserTemplates
     * 
     * @param HTTPRequest $browserTemplate
     */   
    public function testSendJsonHierarchy( $browserTemplate )
    {
        $json = json_encode( array( 'foo' => 'bar', 'moo' => 'cow' ) );
        
        $request = new HTTPRequest( '/ping', 'POST' );
        $request->setHeaders( $browserTemplate->getHeaders() );
        $request->setHeader( 'Accept', 'application/json' );
        $request->setHeader( 'Content-Type', 'application/json' );
        $request->setBody( $json );
        
        $response = $this->transfer( $request );
        
        $this->assertEquals( Code::HTTP_OK, $response->getCode() );
        $this->assertEquals( 'application/json', $response->getContentType() );
        $this->assertEquals( 'UTF-8', $response->getCharacterSet() );
        
        $json = json_decode( $response->getBody(), true );
        
        $this->assertEquals( 'bar', $json[ 'body' ][ 'foo' ] );
        $this->assertEquals( 'cow', $json[ 'body' ][ 'moo' ] );
    }
}
