<?php

namespace Application\Module\RedisExample\Controller;

use \Insomnia\Controller\Action,
    \Application\Module\RedisExample\Bootstrap\Redis,
    \Insomnia\Controller\NotFoundException,
    \Insomnia\Response\Code;

use \Application\Module\RedisExample\DataMapper\Test as DataMapper;
use \Application\Module\RedisExample\Entities\Test as Entity;
use \Application\Module\RedisExample\Entities\Tests as EntityIndex;

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
        $test = new Entity;
        $test->name = $this->validator->getParam( 'name' );
        
        // Save Entity Index
        $tests = new EntityIndex;
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
        $test = new Entity;
        $test->setId( (int) $this->validator->getParam( 'id' ) );

        // Delete Entity
        if( $test->delete() )
        {
            // Update Entity Index
            $tests = new EntityIndex;
            $tests->remove( $test->getId() );
         
            $this->response->setCode( Code::HTTP_OK );
        }
        
        // Entity Not Found
        else throw new \Exception( 'Entity Not Found', 404 );
    }
    
    /**
     * List EntityIndex
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
        
        // Access the Entity primary index
        $tests = new EntityIndex;
        
        if( !$tests->getLength() ) throw new NotFoundException( 'Entity Not Found', 404 );
        
        foreach( $tests->getIterator() as $indexValue )
        {
            $test = new Entity;
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
        
        $test = new Entity;
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
        
        $test = new Entity;
        $test->setId( (int) $this->validator->getParam( 'id' ) );
        
        if( !isset( $test->name ) ) throw new NotFoundException( 'Entity Not Found' );

        $dataMapper = new DataMapper( $test );
        $dataMapper->import( $this->validator->getParams() );

        $this->response->merge( $dataMapper->export() );
    }
}