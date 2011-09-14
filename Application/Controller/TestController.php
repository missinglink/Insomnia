<?php

namespace Application\Controller;

use \Insomnia\Controller\Action,
    \Application\Bootstrap\Doctrine,
    \Application\Controller\TestController,
    \Insomnia\Request\Validator\IntegerValidator,
    \Insomnia\Request\Validator\StringValidator,
    \Insomnia\Controller\NotFoundException,
    \Insomnia\Response\Paginator,
    \Application\Queries\TestQuery;

use \Insomnia\Kernel\Module\RequestValidator\Request\RequestValidator;

use \Application\DataMapper\Test as DataMapper;

/**
 * Test Create Action
 * 
 * @insomnia:Resource
 * @insomnia:Route( "/v1" )
 * 
 */
class TestController extends Action
{    
    /**
     * Create a new Test entity
     * 
     * @insomnia:Route( "/test", name="test_create" )
     * @insomnia:Method( "PUT" )
     * @insomnia:Documentation( category="Test" )
     * 
     * @insomnia:Request({
     *      @insomnia:Param( name="name", type="string", minlength="4", maxlength="10" )
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

        $dataMapper = new DataMapper( $test );
        $this->response->merge( $dataMapper->export() );
    }
    
    /**
     * Delete a Test Entity
     * 
     * @insomnia:Route( "/test/:id", name="test_delete" )
     * @insomnia:Method( "DELETE" )
     * @insomnia:Documentation( category="Test" )
     *
     * @insomnia:Request({
     *      @insomnia:Param( name="id", type="integer" )
     * })
     * 
     */
    public function delete()
    {
        $doctrine = new Doctrine;
        $test = $doctrine->getManager()->find( 'Application\Entities\Test', $this->validator->getParam( 'id' ) );
        if( !$test ) throw new NotFoundException( 'Entity Not Found' );

        $doctrine->getManager()->remove( $test );
        $doctrine->getManager()->flush();

        $this->response[ 'message' ] = 'Entity Deleted';
    }
    
    /**
     * List Tests
     * 
     * @insomnia:Route( "/test", name="test_index" )
     * @insomnia:Method( "GET" )
     * @insomnia:Documentation( category="Test" )
     * 
     * @insomnia:Request({
     *      @insomnia:Param( name="page", type="integer", optional="true" )
     * })
     *
     */
    public function index()
    {
        $doctrine    = new Doctrine;
        $query       = new TestQuery( $doctrine->getManager() );
        $paginator   = new Paginator( $query->getQuery() );
        $paginator->setCurrentPage( $this->validator->getParam( 'page' ) );
        
        $tests = $paginator->getItems();
        if( !$tests ) throw new NotFoundException( 'Entity Not Found' );

        foreach( $tests as $test )
        {
            $dataMapper = new DataMapper( $test );
            $this->response->push( $dataMapper->export() );
        }
    }
    
    /**
     * View a Test
     * 
     * @insomnia:Route( "/test/:id", name="test_read" )
     * @insomnia:Method( "GET" )
     * @insomnia:Documentation( category="Test" )
     * 
     * @insomnia:Request({
     *      @insomnia:Param( name="id", type="integer" )
     * })
     * 
     */
    public function read()
    {
        $doctrine = new Doctrine;
        $test = $doctrine->getManager()->find( 'Application\Entities\Test', $this->validator->getParam( 'id' ) );
        if( !$test ) throw new NotFoundException( 'Entity Not Found' );

        $dataMapper = new DataMapper( $test );
        $this->response->merge( $dataMapper->export() );
    }
    
    /**
     * Update a Test
     * 
     * @insomnia:Route( "/test/:id", name="test_update" )
     * @insomnia:Method( "POST" )
     * @insomnia:Documentation( category="Test" )
     *
     * @insomnia:Request({
     *      @insomnia:Param( name="id", type="integer" ),
     *      @insomnia:Param( name="name", type="string", minlength="4", maxlength="10", optional="true" )
     * })
     * 
     */
    public function update()
    {
        $doctrine = new Doctrine;
        $test = $doctrine->getManager()->find( 'Application\Entities\Test', $this->validator->getParam( 'id' ) );
        if( !$test ) throw new NotFoundException( 'Entity Not Found' );

        $dataMapper = new DataMapper( $test );
        $dataMapper->import( $this->validator->getParams() );
        $doctrine->getManager()->persist( $test );
        $doctrine->getManager()->flush();

        $this->response->merge( $dataMapper->export() );
    }
}