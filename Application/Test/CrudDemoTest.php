<?php

namespace Application\Test;

use \Community\Module\Testing\FunctionalTestCase,
    \Community\Module\Testing\Transport\HTTPRequest,
    \Community\Module\Testing\Transport\HTTPResponse,
    \Insomnia\Response\Code;

/**
 * @group functional
 */
class CrudDemoTest extends FunctionalTestCase
{
    public static $testIds = array();
    public static $testNames = array();
    
    /**
     * @dataProvider getBrowserTemplates
     * 
     * @param HTTPRequest $browserTemplate
     */   
    public function testReadSingleNotFound_Json( $browserTemplate )
    {
        $randomId = mt_rand( mt_getrandmax() - 1000, mt_getrandmax() );
        
        $request = new HTTPRequest( '/example/crud/' . $randomId );
        $request->setHeaders( $browserTemplate->getHeaders() );
        $request->setHeader( 'Accept', 'application/json' );
        
        $response = $this->transfer( $request );
        $this->assertValidResponse( $response, Code::HTTP_NOT_FOUND, 'application/json' );
        
        $json = json_decode( $response->getBody(), true );
        
        $this->assertEquals( Code::HTTP_NOT_FOUND, $json[ 'status' ] );
        $this->assertEquals( 'Resource Not Found', $json[ 'title' ] );
        $this->assertEquals( 'The requested resource could not be found but may be available again in the future', $json[ 'body' ] );
    }
    
    /**
     * @dataProvider getBrowserTemplates
     * 
     * @param HTTPRequest $browserTemplate
     */   
    public function testCreateSingleMissingName_Json( $browserTemplate )
    {
        $request = new HTTPRequest( '/example/crud', 'PUT' );
        $request->setHeaders( $browserTemplate->getHeaders() );
        $request->setHeader( 'Accept', 'application/json' );
        $request->setParam( 'foo', 'bar' );
        
        $response = $this->transfer( $request );
        $this->assertValidResponse( $response, Code::HTTP_BAD_REQUEST, 'application/json' );
    }
    
    /**
     * @dataProvider getBrowserTemplates
     * 
     * @param HTTPRequest $browserTemplate
     */   
    public function testCreateSingle_Json( $browserTemplate )
    {
        $iteration = array_search( array( $browserTemplate ), $this->getBrowserTemplates() );
        $newName = 'Test User #' . md5( rand() );
        
        $request = new HTTPRequest( '/example/crud', 'PUT' );
        $request->setHeaders( $browserTemplate->getHeaders() );
        $request->setHeader( 'Accept', 'application/json' );
        $request->setParam( 'name', $newName );
        
        $response = $this->transfer( $request );
        $this->assertValidResponse( $response, Code::HTTP_CREATED, 'application/json' );
        
        $json = json_decode( $response->getBody(), true );
        
        $this->assertRegExp( '/\d+/', (string) $json[ 'id' ] );
        $this->assertRegExp( '/\w+/', (string) $json[ 'name' ] );
        
        self::$testIds[ $iteration ] = (string) $json[ 'id' ];
        self::$testNames[ $iteration ] = (string) $json[ 'name' ];
    }
    
    /**
     * @dataProvider getBrowserTemplates
     * 
     * @param HTTPRequest $browserTemplate
     */   
    public function testReadSingle_Json( $browserTemplate )
    {
        $iteration = array_search( array( $browserTemplate ), $this->getBrowserTemplates() );
        
        $request = new HTTPRequest( '/example/crud/' . self::$testIds[ $iteration ] );
        $request->setHeaders( $browserTemplate->getHeaders() );
        $request->setHeader( 'Accept', 'application/json' );
        
        $response = $this->transfer( $request );
        $this->assertValidResponse( $response, Code::HTTP_OK, 'application/json' );
        
        $json = json_decode( $response->getBody(), true );
        
        $this->assertEquals( self::$testIds[ $iteration ], (int) $json[ 'id' ] );
        $this->assertEquals( self::$testNames[ $iteration ], (string) $json[ 'name' ] );
    }
    
    /**
     * @dataProvider getBrowserTemplates
     * 
     * @param HTTPRequest $browserTemplate
     */   
    public function testReadMany_Json( $browserTemplate )
    {
        $request = new HTTPRequest( '/example/crud' );
        $request->setHeaders( $browserTemplate->getHeaders() );
        $request->setHeader( 'Accept', 'application/json' );
        
        $response = $this->transfer( $request );
        $this->assertValidResponse( $response, Code::HTTP_OK, 'application/json' );
        
        $json = json_decode( $response->getBody(), true );
        
        $this->assertRegExp( '/\d+/', (string) $json[ 0 ][ 'id' ] );
        $this->assertRegExp( '/\w+/', (string) $json[ 0 ][ 'name' ] );
    }
    
    /**
     * @dataProvider getBrowserTemplates
     * 
     * @param HTTPRequest $browserTemplate
     */   
    public function testUpdateSingle_Json( $browserTemplate )
    {
        $iteration = array_search( array( $browserTemplate ), $this->getBrowserTemplates() );
        $newName = 'Test User #' . md5( rand() );
        
        $request = new HTTPRequest( '/example/crud/' . self::$testIds[ $iteration ], 'POST' );
        $request->setHeaders( $browserTemplate->getHeaders() );
        $request->setHeader( 'Accept', 'application/json' );
        $request->setParam( 'name', $newName );
       
        $response = $this->transfer( $request );
        $this->assertValidResponse( $response, Code::HTTP_OK, 'application/json' );
        
        $json = json_decode( $response->getBody(), true );
        
        $this->assertEquals( self::$testIds[ $iteration ], (int) $json[ 'id' ] );
        $this->assertEquals( $newName, (string) $json[ 'name' ] );
        
        self::$testNames[ $iteration ] = $newName;
    }
    
    /**
     * @dataProvider getBrowserTemplates
     * 
     * @param HTTPRequest $browserTemplate
     */   
    public function testDeleteSingle_Json( $browserTemplate )
    {
        $iteration = array_search( array( $browserTemplate ), $this->getBrowserTemplates() );
        
        $request = new HTTPRequest( '/example/crud/' . self::$testIds[ $iteration ], 'DELETE' );
        $request->setHeaders( $browserTemplate->getHeaders() );
        $request->setHeader( 'Accept', 'application/json' );
        
        $response = $this->transfer( $request );
        $this->assertValidResponse( $response, Code::HTTP_OK, 'application/json' );
        
        $json = json_decode( $response->getBody(), true );
        
        $this->assertEquals( 'Entity Deleted', (string) $json[ 'message' ] );
    }
}
