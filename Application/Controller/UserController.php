<?php

namespace Application\Controller;

use \Insomnia\Controller\Action,
    \Application\Bootstrap\Doctrine,
    \Insomnia\Request\Validator\IntegerValidator,
    \Insomnia\Request\Validator\StringValidator,
    \Insomnia\Controller\NotFoundException,
    \Insomnia\Response\Paginator,
    \Application\Queries\UserQuery;

use \Insomnia\Kernel\Module\RequestValidator\Request\RequestValidator;

use \Application\DataMapper\User as DataMapper;
/**
 * User Create Action
 * 
 * @insomnia:Resource
 * @insomnia:Route( "/v1" )
 * 
 */
class UserController extends Action
{    
    /**
     * Create a new User entity
     * 
     * @insomnia:Route( "/user", name="user_create" )
     * @insomnia:Method( "PUT" )
     * @insomnia:Documentation( category="User" )
     * 
     * @insomnia:Request({
     *      @insomnia:Param( name="name", type="string", minlength="4", maxlength="10" ),
     *      @insomnia:Param( name="email", type="string", minlength="4", maxlength="255" )
     * })
     * 
     */
    public function create()
    {
        $user = new \Application\Entities\User;
        $dataMapper = new DataMapper( $user );
        $dataMapper->import( $this->validator->getParams() );

        $doctrine = new Doctrine;
        $doctrine->getManager()->persist( $user );
        $doctrine->getManager()->flush();

        $this->response->merge( $dataMapper->export() );
    }
    
    /**
     * Delete a User Entity
     * 
     * @insomnia:Route( "/user/:id", name="user_delete" )
     * @insomnia:Method( "DELETE" )
     * @insomnia:Documentation( category="User" )
     *
     * @insomnia:Request({
     *      @insomnia:Param( name="id", type="integer" )
     * })
     * 
     */
    public function delete()
    {
        $doctrine = new Doctrine;
        $user = $doctrine->getManager()->find( 'Application\Entities\User', $this->validator->getParam( 'id' ) );
        if( !$user ) throw new NotFoundException( 'Entity Not Found' );

        $doctrine->getManager()->remove( $user );
        $doctrine->getManager()->flush();

        $this->response[ 'message' ] = 'Entity Deleted';
    }
    
    /**
     * List Users
     * 
     * @insomnia:Route( "/user", name="user_index" )
     * @insomnia:Method( "GET" )
     * @insomnia:Documentation( category="User" )
     * 
     * @insomnia:Request({
     *      @insomnia:Param( name="page", type="integer", optional="true" )
     * })
     *
     */
    public function index()
    {
        $doctrine    = new Doctrine;
        $query       = new UserQuery( $doctrine->getManager() );
        $paginator   = new Paginator( $query->getQuery() );
        $paginator->setCurrentPage( $this->validator->getParam( 'page' ) );
        
        $users = $paginator->getItems();
        if( !$users ) throw new NotFoundException( 'Entity Not Found' );

        foreach( $users as $user )
        {
            $dataMapper = new DataMapper( $user );
            $this->response->push( $dataMapper->export() );
        }
    }
    
    /**
     * View a User
     * 
     * @insomnia:Route( "/user/:id", name="user_read" )
     * @insomnia:Method( "GET" )
     * @insomnia:Documentation( category="User" )
     * 
     * @insomnia:Request({
     *      @insomnia:Param( name="id", type="integer" )
     * })
     * 
     */
    public function read()
    {
        $doctrine = new Doctrine;
        $user = $doctrine->getManager()->find( 'Application\Entities\User', $this->validator->getParam( 'id' ) );
        if( !$user ) throw new NotFoundException( 'Entity Not Found' );

        $dataMapper = new DataMapper( $user );
        $this->response->merge( $dataMapper->export() );
    }
    
    /**
     * Update a User
     * 
     * @insomnia:Route( "/user/:id", name="user_update" )
     * @insomnia:Method( "POST" )
     * @insomnia:Documentation( category="User" )
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
        $user = $doctrine->getManager()->find( 'Application\Entities\User', $this->validator->getParam( 'id' ) );
        if( !$user ) throw new NotFoundException( 'Entity Not Found' );

        $dataMapper = new DataMapper( $user );
        $dataMapper->import( $this->validator->getParams() );
        $doctrine->getManager()->persist( $user );
        $doctrine->getManager()->flush();

        $this->response->merge( $dataMapper->export() );
    }
}