<?php

namespace Application\Module\RedisExample\Controller;

use \Insomnia\Controller\Action,
    \Application\Module\RedisExample\Bootstrap\Redis,
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
 * @Insomnia\Annotation\Resource
 * @Insomnia\Annotation\Route( "/example" )
 * 
 */
class RedisController extends Action
{    
    /**
     * Create a new Entity
     * 
     * @Insomnia\Annotation\Route( "/redis", name="redis_test_create" )
     * @Insomnia\Annotation\Method( "PUT" )
     * @Insomnia\Annotation\Documentation( category="Redis Demo" )
     * 
     * @Insomnia\Annotation\Request({
     *      @Insomnia\Annotation\Param( name="name", type="string" )
     * })
     * 
     */
    public function create()
    {
        $redis = new Redis;
        
        // Save Entity
        $test = new \Application\Module\RedisExample\Entities\Test;
        $test->name = $this->validator->getParam( 'name' );
        
        // Save Entity Index
        $tests = new \Application\Module\RedisExample\Entities\Tests;
        $tests->add( $test->getId() );

        $dataMapper = new DataMapper( $test );
        $this->response->merge( $dataMapper->export() );
        $this->response->setCode( Code::HTTP_CREATED );
    }
    
    /**
     * Delete a Entity
     * 
     * @Insomnia\Annotation\Route( "/redis/:id", name="redis_test_delete" )
     * @Insomnia\Annotation\Method( "DELETE" )
     * @Insomnia\Annotation\Documentation( category="Redis Demo" )
     *
     * @Insomnia\Annotation\Request({
     *      @Insomnia\Annotation\Param( name="id", type="integer" )
     * })
     * 
     */
    public function delete()
    {
        $redis = new Redis;
        
        // Create Entity
        $test = new \Application\Module\RedisExample\Entities\Test;
        $test->setId( (int) $this->validator->getParam( 'id' ) );

        // Delete Entity
        if( $test->delete() )
        {
            // Update Entity Index
            $tests = new \Application\Module\RedisExample\Entities\Tests;
            $tests->remove( $test->getId() );
         
            $this->response->setCode( Code::HTTP_OK );
        }
        
        // Entity Not Found
        else throw new \Exception( 'Entity Not Found', 404 );
    }
    
    /**
     * List Entities
     * 
     * @Insomnia\Annotation\Route( "/redis", name="redis_test_index" )
     * @Insomnia\Annotation\Method( "GET" )
     * @Insomnia\Annotation\Documentation( category="Redis Demo" )
     * 
     * @Insomnia\Annotation\Request({
     *      @Insomnia\Annotation\Param( name="page", type="integer", optional="true" )
     * })
     *
     */
    public function index()
    {
        $redis = new Redis;
        
        // Update Entity Index
        $tests = new \Application\Module\RedisExample\Entities\Tests;
        $iterator = $tests->getIterator();
        
        if( !$iterator->count() ) throw new NotFoundException( 'Entity Not Found', 404 );
        
        foreach( $iterator as $indexValue )
        {
            $test = new \Application\Module\RedisExample\Entities\Test;
            $test->setId( $indexValue );

            $dataMapper = new DataMapper( $test );
            $this->response->push( $dataMapper->export() );
        }
    }
    
    /**
     * View a Single Entity
     * 
     * @Insomnia\Annotation\Route( "/redis/:id", name="redis_test_read" )
     * @Insomnia\Annotation\Method( "GET" )
     * @Insomnia\Annotation\Documentation( category="Redis Demo" )
     * 
     * @Insomnia\Annotation\Request({
     *      @Insomnia\Annotation\Param( name="id", type="integer" )
     * })
     * 
     */
    public function read()
    {
        $redis = new Redis;
        
        $test = new \Application\Module\RedisExample\Entities\Test;
        $test->setId( (int) $this->validator->getParam( 'id' ) );
        
        if( !isset( $test->name ) ) throw new NotFoundException( 'Entity Not Found' );

        $dataMapper = new DataMapper( $test );
        $this->response->merge( $dataMapper->export() );
    }
    
    /**
     * Update an Entity
     * 
     * @Insomnia\Annotation\Route( "/redis/:id", name="redis_test_update" )
     * @Insomnia\Annotation\Method( "POST" )
     * @Insomnia\Annotation\Documentation( category="Redis Demo" )
     *
     * @Insomnia\Annotation\Request({
     *      @Insomnia\Annotation\Param( name="id", type="integer" ),
     *      @Insomnia\Annotation\Param( name="name", type="string" )
     * })
     * 
     */
    public function update()
    {
        $redis = new Redis;
        
        $test = new \Application\Module\RedisExample\Entities\Test;
        $test->setId( (int) $this->validator->getParam( 'id' ) );
        
        if( !isset( $test->name ) ) throw new NotFoundException( 'Entity Not Found' );

        $dataMapper = new DataMapper( $test );
        $dataMapper->import( $this->validator->getParams() );

        $this->response->merge( $dataMapper->export() );
    }

    /**
     * RedisExample Setup Help
     *
     * @Insomnia\Annotation\Route( "/redis/setup", name="redis_setup" )
     * @Insomnia\Annotation\Method( "GET" )
     *
     * @Insomnia\Annotation\View( "Application\Module\RedisExample\View\Setup" )
     * @Insomnia\Annotation\Layout( "Insomnia\Kernel\Module\Mime\View\Layout" )
     * @Insomnia\Annotation\Documentation( category="Redis Demo" )
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