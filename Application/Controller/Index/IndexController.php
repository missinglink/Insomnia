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

    public function indexValidate()
    {
        $validator = new RequestValidator( $this->request );
        $validator->required( 'id',     new IntegerValidator );
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
    
    private function map( $entity )
    {
        $a = array();
        $a[ 'id' ]      = $entity->getId();
        $a[ 'name' ]    = $entity->getName();
        return $a;
    }
}