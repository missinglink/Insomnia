<?php

namespace Application\Module\CrudExample\Controller;

use \Insomnia\Controller\Action,
    \Application\Module\CrudExample\Bootstrap\Doctrine,
    \Application\Controller\TestController,
    \Insomnia\Request\Validator\IntegerValidator,
    \Insomnia\Request\Validator\StringValidator,
    \Insomnia\Controller\NotFoundException,
    \Insomnia\Response\Paginator,
    \Insomnia\Response\Code,
    \Application\Module\CrudExample\Queries\TestQuery;

use \Insomnia\Kernel\Module\RequestValidator\Request\RequestValidator;

use \Application\Module\CrudExample\DataMapper\Test as DataMapper;
use \Application\Module\CrudExample\Entities\Test as ExampleEntity;

/**
 * Test Create Action
 * 
 * @Insomnia\Annotation\Resource
 * @Insomnia\Annotation\Route( "/example" )
 * 
 */
class CrudController extends Action
{    
    /**
     * Create a new Entity
     * 
     * @Insomnia\Annotation\Route( "/crud", name="test_create" )
     * @Insomnia\Annotation\Method( "PUT" )
     * @Insomnia\Annotation\Documentation( category="Crud Demo" )
     * 
     * @Insomnia\Annotation\Request({
     *      @Insomnia\Annotation\Param( name="name", type="string", minlength="4", maxlength="10" )
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
        $this->response->setCode( Code::HTTP_CREATED );
    }
    
    /**
     * Delete a Entity
     * 
     * @Insomnia\Annotation\Route( "/crud/:id", name="test_delete" )
     * @Insomnia\Annotation\Method( "DELETE" )
     * @Insomnia\Annotation\Documentation( category="Crud Demo" )
     *
     * @Insomnia\Annotation\Request({
     *      @Insomnia\Annotation\Param( name="id", type="integer" )
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
     * @Insomnia\Annotation\Route( "/crud", name="test_index" )
     * @Insomnia\Annotation\Method( "GET" )
     * @Insomnia\Annotation\Documentation( category="Crud Demo" )
     * 
     * @Insomnia\Annotation\Request({
     *      @Insomnia\Annotation\Param( name="page", type="integer", optional="true" )
     * })
     *
     */
    public function index()
    {
        $doctrine    = new Doctrine;
        $query       = new TestQuery( $doctrine->getManager() );
        
        $queryObject = $query->getQuery();
        $queryObject->useResultCache( true, 99999 );
        
        $paginator   = new Paginator( $queryObject );
        $paginator->setCurrentPage( $this->validator->getParam( 'page' ) );
        
        $tests = $paginator->getItems();
        if( !$tests ) throw new NotFoundException( 'Entity Not Found', 404 );

        foreach( $tests as $test )
        {
            $dataMapper = new DataMapper( $test );
            $this->response->push( $dataMapper->export() );
        }
    }
    
    /**
     * View a Single Entity
     * 
     * @Insomnia\Annotation\Route( "/crud/:id", name="test_read" )
     * @Insomnia\Annotation\Method( "GET" )
     * @Insomnia\Annotation\Documentation( category="Crud Demo" )
     * 
     * @Insomnia\Annotation\Request({
     *      @Insomnia\Annotation\Param( name="id", type="integer" )
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
                    ->getResult();
        
        if( !$test ) throw new NotFoundException( 'Entity Not Found' );

        $dataMapper = new DataMapper( reset( $test ) );
        $this->response->merge( $dataMapper->export() );
    }
    
    /**
     * Update an Entity
     * 
     * @Insomnia\Annotation\Route( "/crud/:id", name="test_update" )
     * @Insomnia\Annotation\Method( "POST" )
     * @Insomnia\Annotation\Documentation( category="Crud Demo" )
     *
     * @Insomnia\Annotation\Request({
     *      @Insomnia\Annotation\Param( name="id", type="integer" ),
     *      @Insomnia\Annotation\Param( name="name", type="string", minlength="4", maxlength="10", optional="true" )
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

    /**
     * CrudExample Setup Help
     *
     * @Insomnia\Annotation\Route( "/crud/setup", name="CrudExample_setup" )
     * @Insomnia\Annotation\Method( "GET" )
     *
     * @Insomnia\Annotation\View( "Application\Module\CrudExample\View\Setup" )
     * @Insomnia\Annotation\Layout( "Insomnia\Kernel\Module\Mime\View\Layout" )
     * @Insomnia\Annotation\Documentation( category="Crud Demo" )
     *
     */
    public function setup()
    {
        $this->response[ 'setup' ] = array(
            'title' => 'Setting up the example',
            'description' => 'You must setup your database before running this example',
            'example' => file_get_contents( __DIR__ . '../../Scripts/user_create.sql' ),
        );
    }
}