<?php

namespace Application\Module\CrudExample\Controller;

use \Insomnia\Controller\Action,
    \Application\Bootstrap\Doctrine,
    \Application\Controller\TestController,
    \Insomnia\Request\Validator\IntegerValidator,
    \Insomnia\Request\Validator\StringValidator,
    \Insomnia\Controller\NotFoundException,
    \Insomnia\Response\Paginator,
    \Application\Module\CrudExample\Queries\TestQuery;

use \Insomnia\Kernel\Module\RequestValidator\Request\RequestValidator;

use \Application\Module\CrudExample\DataMapper\Test as DataMapper;
use \Application\Module\CrudExample\Entities as ExampleEntity;

/**
 * Test Create Action
 * 
 * @insomnia:Resource
 * @insomnia:Route( "/example" )
 * 
 */
class CrudController extends Action
{    
    /**
     * Create a new Entity
     * 
     * @insomnia:Route( "/crud", name="test_create" )
     * @insomnia:Method( "PUT" )
     * @insomnia:Documentation( category="Crud Demo" )
     * 
     * @insomnia:Request({
     *      @insomnia:Param( name="name", type="string", minlength="4", maxlength="10" )
     * })
     * 
     */
    public function create()
    {
        $test = new ExampleEntity;
        $test->setName( $this->validator->getParam( 'name' ) );

        $doctrine = new Doctrine;
        $doctrine->getManager()->persist( $test );
        $doctrine->getManager()->flush();

        $dataMapper = new DataMapper( $test );
        $this->response->merge( $dataMapper->export() );
    }
    
    /**
     * Delete a Entity
     * 
     * @insomnia:Route( "/crud/:id", name="test_delete" )
     * @insomnia:Method( "DELETE" )
     * @insomnia:Documentation( category="Crud Demo" )
     *
     * @insomnia:Request({
     *      @insomnia:Param( name="id", type="integer" )
     * })
     * 
     */
    public function delete()
    {
        $doctrine = new Doctrine;
        $test = $doctrine->getManager()->find( 'Application\Module\CrudExample\Entities\Test', $this->validator->getParam( 'id' ) );
        if( !$test ) throw new NotFoundException( 'Entity Not Found' );

        $doctrine->getManager()->remove( $test );
        $doctrine->getManager()->flush();

        $this->response[ 'message' ] = 'Entity Deleted';
    }
    
    /**
     * List Entities
     * 
     * @insomnia:Route( "/crud", name="test_index" )
     * @insomnia:Method( "GET" )
     * @insomnia:Documentation( category="Crud Demo" )
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
     * View a Single Entity
     * 
     * @insomnia:Route( "/crud/:id", name="test_read" )
     * @insomnia:Method( "GET" )
     * @insomnia:Documentation( category="Crud Demo" )
     * 
     * @insomnia:Request({
     *      @insomnia:Param( name="id", type="integer" )
     * })
     * 
     */
    public function read()
    {
        $doctrine = new Doctrine;
        $test = $doctrine->getManager()
                    ->createQuery( 'SELECT t FROM Application\Module\CrudExample\Entities\Test t WHERE t.id = :id' )
                    ->useResultCache( true, 99999 )
                    ->setParameter( 'id', $this->validator->getParam( 'id' ) )
                    ->getSingleResult();
        
        if( !$test ) throw new NotFoundException( 'Entity Not Found' );

        $dataMapper = new DataMapper( $test );
        $this->response->merge( $dataMapper->export() );
    }
    
    /**
     * Update an Entity
     * 
     * @insomnia:Route( "/crud/:id", name="test_update" )
     * @insomnia:Method( "POST" )
     * @insomnia:Documentation( category="Crud Demo" )
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
        $test = $doctrine->getManager()->find( 'Application\Module\CrudExample\Entities\Test', $this->validator->getParam( 'id' ) );
        if( !$test ) throw new NotFoundException( 'Entity Not Found' );

        $dataMapper = new DataMapper( $test );
        $dataMapper->import( $this->validator->getParams() );
        $doctrine->getManager()->persist( $test );
        $doctrine->getManager()->flush();

        $this->response->merge( $dataMapper->export() );
    }
}