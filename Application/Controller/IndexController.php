<?php

namespace Application\Controller;

use \Insomnia\Controller\ControllerAbstract,
    \Application\Bootstrap\Doctrine,
    \Insomnia\Session,
    \Insomnia\Request\RequestValidator,
    \Insomnia\Controller\NotFoundException,
    \Insomnia\Response\Format\JsonRenderer,
    \Insomnia\Request\Validator\RegexValidator,
    \Insomnia\Request\Validator\IntegerValidator,
    \Insomnia\Request\Validator\StringValidator;

class IndexController extends ControllerAbstract
{
    public function preDispatch( $controller, $action )
    {
        parent::preDispatch( $controller, $action );
        $this->response->setRenderer( new JsonRenderer );
    }

    public function create()
    {
//        $session = new Session;
//        $session->authenticate( $this->request );
//
        $validator = new RequestValidator( $this->request );
        $validator->required( 'name', '/^(.+){4,10}$/' );

        $test = new \Application\Entities\Test;
        $test->setName( $this->request[ 'name' ] );

        $doctrine = new Doctrine;
        $doctrine->getManager()->persist( $test );
        $doctrine->getManager()->flush();
        
        $this->response->merge( $test->toArray() );
    }

    public function indexValidate()
    {
        $validator = new RequestValidator( $this->request );
        $validator->optional( 'id',     new IntegerValidator );
        $validator->optional( 'name',   new StringValidator( 1, 10 ) );
    }

    public function index()
    {
        $doctrine = new Doctrine;
        
        $results = $doctrine->getManager()->getRepository( 'Application\Entities\Test' )->findAll();
        if( !$results ) throw new NotFoundException( 'Entity Not Found' );

        foreach( $results as $result )
            $this->response[] = $result->toArray();
    }

    public function readValidate()
    {
        $validator = new RequestValidator( $this->request );
        $validator->required( 'id',     new IntegerValidator );
        $validator->optional( 'name',   new StringValidator( 1, 10 ) );
    }

    public function read()
    {
        $doctrine = new Doctrine;
        $result = $doctrine->getManager()->find( 'Application\Entities\Test', $this->request[ 'id' ] );
        if( !$result ) throw new NotFoundException( 'Entity Not Found' );

        $this->response->merge( $this->map( $result ) );
    }

    public function update()
    {
        $validator = new RequestValidator( $this->request );
        $validator->required( 'id', '/^(\d+){1,10}$/' );
        $validator->optional( 'name', '/^(.+){4,10}$/' );

        $doctrine = new Doctrine;
        $result = $doctrine->getManager()->find( 'Application\Entities\Test', $this->request['id'] );
        if( !$result ) throw new NotFoundException( 'Entity Not Found' );

        if( isset( $this->request[ 'name' ] ) )
        {
            $result->setName( $this->request[ 'name' ] );
            $doctrine->getManager()->persist( $result );
            $doctrine->getManager()->flush();
        }

        $this->response->merge( $this->map( $result ) );
    }

    public function delete()
    {
        $validator = new RequestValidator( $this->request );
        $validator->required( 'id', '/^(\d+){1,10}$/' );

        $doctrine = new Doctrine;
        $result = $doctrine->getManager()->find( 'Application\Entities\Test', $this->request['id'] );
        if( !$result ) throw new NotFoundException( 'Entity Not Found' );

        $doctrine->getManager()->remove( $result );
        $doctrine->getManager()->flush();

        $this->response[ 'body' ] = 'Entity Deleted';
    }

    private function map( $entity )
    {
        $a = array();
        $a[ 'id' ]      = $entity->getId();
        $a[ 'name' ]    = $entity->getName();
        return $a;
    }
}