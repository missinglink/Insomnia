<?php

namespace Application\Module\RedisExample\Controller;

use \Insomnia\Controller\Action,
    \Application\Module\RedisExample\Bootstrap\Doctrine,
    \Application\Controller\TestController,
    \Insomnia\Request\Validator\IntegerValidator,
    \Insomnia\Request\Validator\StringValidator,
    \Insomnia\Controller\NotFoundException,
    \Insomnia\Response\Paginator,
    \Insomnia\Response\Code,
    \Application\Module\RedisExample\Queries\TestQuery;

use \Insomnia\Kernel\Module\RequestValidator\Request\RequestValidator;

use \Application\Module\RedisExample\DataMapper\Test as DataMapper;
use \Application\Module\RedisExample\Entities\Test as ExampleEntity;

/**
 * Test Create Action
 * 
 * @insomnia:Resource
 * @insomnia:Route( "/example" )
 * 
 */
class RedisController extends Action
{    
    /**
     * Create a new Entity
     * 
     * @insomnia:Route( "/redis", name="test_create" )
     * @insomnia:Method( "PUT" )
     * @insomnia:Documentation( category="Redis Demo" )
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
        $this->response->setCode( Code::HTTP_CREATED );
    }
    
    /**
     * Delete a Entity
     * 
     * @insomnia:Route( "/redis/:id", name="test_delete" )
     * @insomnia:Method( "DELETE" )
     * @insomnia:Documentation( category="Redis Demo" )
     *
     * @insomnia:Request({
     *      @insomnia:Param( name="id", type="integer" )
     * })
     * 
     */
    public function delete()
    {
        $doctrine = new Doctrine;
        $test = $doctrine->getManager()->find( 'Application\Module\RedisExample\Entities\Test', $this->validator->getParam( 'id' ) );
        if( !$test ) throw new NotFoundException( 'Entity Not Found' );

        $doctrine->getManager()->remove( $test );
        $doctrine->getManager()->flush();

        $this->response[ 'message' ] = 'Entity Deleted';
    }
    
    /**
     * List Entities
     * 
     * @insomnia:Route( "/redis", name="test_index" )
     * @insomnia:Method( "GET" )
     * @insomnia:Documentation( category="Redis Demo" )
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
     * @insomnia:Route( "/redis/:id", name="test_read" )
     * @insomnia:Method( "GET" )
     * @insomnia:Documentation( category="Redis Demo" )
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
                    ->createQuery( 'SELECT t FROM Application\Module\RedisExample\Entities\Test t WHERE t.id = :id' )
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
     * @insomnia:Route( "/redis/:id", name="test_update" )
     * @insomnia:Method( "POST" )
     * @insomnia:Documentation( category="Redis Demo" )
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
        $test = $doctrine->getManager()->find( 'Application\Module\RedisExample\Entities\Test', $this->validator->getParam( 'id' ) );
        if( !$test ) throw new NotFoundException( 'Entity Not Found' );

        $dataMapper = new DataMapper( $test );
        $dataMapper->import( $this->validator->getParams() );
        $doctrine->getManager()->persist( $test );
        $doctrine->getManager()->flush();

        $this->response->merge( $dataMapper->export() );
    }

    /**
     * RedisExample Setup Help
     *
     * @insomnia:Route( "/redis/setup", name="RedisExample_setup" )
     * @insomnia:Method( "GET" )
     *
     * @insomnia:View( "Application\Module\RedisExample\View\Setup" )
     * @insomnia:Layout( "Insomnia\Kernel\Module\Mime\View\Layout" )
     * @insomnia:Documentation( category="Redis Demo" )
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