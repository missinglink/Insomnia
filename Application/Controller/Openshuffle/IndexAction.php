<?php

namespace Application\Controller\Openshuffle;

use \Application\Bootstrap\Doctrine,
    \Insomnia\Controller\Action,
    \Insomnia\Controller\NotFoundException,
    \Insomnia\Request\Validator\IntegerValidator,
    \Insomnia\Response\Paginator,
    \Application\Queries\PlayerQuery;

class IndexAction extends Action
{
    public function __construct()
    {
        parent::__construct();
        $this->response->setContentType( 'application/json' );
    }

    public function validate()
    {
        $this->validator->optional( 'page', new IntegerValidator );
    }

    public function action()
    {
        $doctrine    = new Doctrine;
        $query       = new PlayerQuery( $doctrine->getManager() );
        $paginator   = new Paginator( $query->findAll() );
        $paginator->setCurrentPage( $this->validator->getParam( 'page' ) );
        
        $results = $paginator->getItems();
        if( !$results ) throw new NotFoundException( 'Entity Not Found' );

        foreach( $results as $result )
            $this->response->push( $result->toArray() );
    }
}