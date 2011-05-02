<?php

namespace Application\Controller\Test;

use \Application\Bootstrap\Doctrine,
    \Application\Controller\TestController,
    \Insomnia\Controller\NotFoundException,
    \Insomnia\Request\Validator\IntegerValidator,
    \Insomnia\Response\Paginator,
    \Application\Queries\TestQuery;

class IndexAction extends TestController
{
    public function validate()
    {
        $this->validator->optional( 'page', new IntegerValidator );
    }

    public function action()
    {
        $doctrine    = new Doctrine;
        $query       = new TestQuery( $doctrine->getManager() );
        $paginator   = new Paginator( $query->getQuery() );
        $paginator->setCurrentPage( $this->validator->getParam( 'page' ) );
        
        $results = $paginator->getItems();
        if( !$results ) throw new NotFoundException( 'Entity Not Found' );

        foreach( $results as $result )
            $this->response->push( $result->toArray() );
    }
}