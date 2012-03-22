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
        
        $request = new HTTPRequest( '/ping' , 'POST' );
        $request->setHeaders( $browserTemplate->getHeaders() );
        $request->setHeader( 'Accept', 'application/json' );
        $request->setHeader( 'Content-Type', 'application/json' );
        $request->setBody( $json );
        
        $response = $this->transfer( $request );
        
        $this->assertEquals( Code::HTTP_OK, $response->getCode() );
        $this->assertEquals( 'application/json', $response->getContentType() );
        $this->assertEquals( 'UTF-8', $response->getCharacterSet() );
        
        $json = json_decode( $response->getBody(), true );
        
        $this->assertArrayHasKey( 'body', $json );
        $this->assertArrayHasKey( 'foo', $json[ 'body' ] );
        $this->assertArrayHasKey( 'moo', $json[ 'body' ] );
        
        $this->assertEquals( 'bar', $json[ 'body' ][ 'foo' ] );
        $this->assertEquals( 'cow', $json[ 'body' ][ 'moo' ] );
    }
    
    /**
     * @dataProvider getBrowserTemplates
     * 
     * @param HTTPRequest $browserTemplate
     */   
    public function testSetJsonAndUrlFormEncodedAreTreatedIdentically( $browserTemplate )
    {
        $data1 = new \stdClass;
        $data1->message_id = 99999;
        $data1->isRead = 1;
        
        $data2 = new \stdClass;
        $data2->message_id = '99998';
        $data2->isRead = 0;
        
        $data = array( 'data' => array( $data2, $data2 ) );
        
        $bodyUrlEncoded = http_build_query( $data );
        $bodyJsonEncoded = urlencode( json_encode( $data ) );
        
        $requestUrlEncoded = new HTTPRequest( '/ping', 'PUT' );
        $requestUrlEncoded->setHeaders( $browserTemplate->getHeaders() );
        $requestUrlEncoded->setHeader( 'Accept', 'application/json' );
        $requestUrlEncoded->setBody( $bodyUrlEncoded );
        
        $response1 = $this->transfer( $requestUrlEncoded );
        $this->assertValidResponse( $response1, Code::HTTP_OK, 'application/json' );
        
        $requestJsonEncoded = new HTTPRequest( '/ping', 'PUT' );
        $requestJsonEncoded->setHeaders( $browserTemplate->getHeaders() );
        $requestJsonEncoded->setHeader( 'Content-Type', 'application/json' );
        $requestJsonEncoded->setHeader( 'Accept', 'application/json' );
        $requestJsonEncoded->setBody( $bodyJsonEncoded );
        
        $response2 = $this->transfer( $requestJsonEncoded );
        $this->assertValidResponse( $response2, Code::HTTP_OK, 'application/json' );
        
        $this->assertEquals( json_decode( $response1->getBody() )->body->data, json_decode( $response2->getBody() )->body->data );
    }
}
