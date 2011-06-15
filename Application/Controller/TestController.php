<?php

namespace Application\Controller;

use \Insomnia\Controller\Action,
    \Application\Bootstrap\Doctrine,
    \Application\Controller\TestController,
    \Insomnia\Request\RequestValidator,
    \Insomnia\Request\Validator\IntegerValidator,
    \Insomnia\Request\Validator\StringValidator,
    \Insomnia\Controller\NotFoundException,
    \Insomnia\Response\Paginator,
    \Application\Queries\TestQuery;

/**
 * Test Create Action
 * 
 * @webservice:Resource
 * @webservice:Route( "/v1" )
 * 
 */
class TestController extends Action
{    
    /**
     * Create a new Test entity
     * 
     * @webservice:Route( "/test", name="test_create" )
     * @webservice:Method( "PUT" )
     * @webservice:Documentation( category="Test" )
     * 
     * @webservice:Request({
     *      @webservice:Param( name="name", type="string", minlength="4", maxlength="10" )
     * })
     * 
     */
    public function create()
    {
        $test = new \Application\Entities\Test;
        $test->setName( $this->validator->getParam( 'name' ) );

        $doctrine = new Doctrine;
        $doctrine->getManager()->persist( $test );
        $doctrine->getManager()->flush();

        $this->response->merge( $test->toArray() );
    }
    
    /**
     * Delete a Test Entity
     * 
     * @webservice:Route( "/test/:id", name="test_delete" )
     * @webservice:Method( "DELETE" )
     * @webservice:Documentation( category="Test" )
     *
     * @webservice:Request({
     *      @webservice:Param( name="id", type="integer" )
     * })
     * 
     */
    public function delete()
    {
        $doctrine = new Doctrine;
        $result = $doctrine->getManager()->find( 'Application\Entities\Test', $this->validator->getParam( 'id' ) );
        if( !$result ) throw new NotFoundException( 'Entity Not Found' );

        $doctrine->getManager()->remove( $result );
        $doctrine->getManager()->flush();

        $this->response[ 'message' ] = 'Entity Deleted';
    }
    
    /**
     * List Tests
     * 
     * @webservice:Route( "/test", name="test_index" )
     * @webservice:Method( "GET" )
     * @webservice:Documentation( category="Test" )
     * 
     * @webservice:Request({
     *      @webservice:Param( name="page", type="integer", optional="true" )
     * })
     *
     */
    public function index()
    {
        $doctrine    = new Doctrine;
        $query       = new TestQuery( $doctrine->getManager() );
        $paginator   = new Paginator( $query->getQuery() );
        $paginator->setCurrentPage( $this->validator->getParam( 'page' ) );
        
        $results = $paginator->getItems();
        if( !$results ) throw new NotFoundException( 'Entity Not Found' );

        foreach( $results as $result )
            $this->response->push( $result->toArray() );
    }
    
    /**
     * View a Test
     * 
     * @webservice:Route( "/test/:id", name="test_read" )
     * @webservice:Method( "GET" )
     * @webservice:Documentation( category="Test" )
     * 
     * @webservice:Request({
     *      @webservice:Param( name="id", type="integer" )
     * })
     * 
     */
    public function read()
    {
        $doctrine = new Doctrine;
        $result = $doctrine->getManager()->find( 'Application\Entities\Test', $this->validator->getParam( 'id' ) );
        if( !$result ) throw new NotFoundException( 'Entity Not Found' );

        $this->response->merge( $result->toArray() );
    }
    
    /**
     * Update a Test
     * 
     * @webservice:Route( "/test/:id", name="test_update" )
     * @webservice:Method( "POST" )
     * @webservice:Documentation( category="Test" )
     *
     * @webservice:Request({
     *      @webservice:Param( name="id", type="integer" ),
     *      @webservice:Param( name="name", type="string", minlength="4", maxlength="10", optional="true" )
     * })
     * 
     */
    public function update()
    {
        $doctrine = new Doctrine;
        $result = $doctrine->getManager()->find( 'Application\Entities\Test', $this->validator->getParam( 'id' ) );
        if( !$result ) throw new NotFoundException( 'Entity Not Found' );

        $result->fromArray( $this->validator->getParams() );
        $doctrine->getManager()->persist( $result );
        $doctrine->getManager()->flush();

        $this->response->merge( $result->toArray() );
    }
}