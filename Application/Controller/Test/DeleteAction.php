<?php

namespace Application\Controller\Test;

use \Application\Bootstrap\Doctrine,
    \Application\Controller\TestController,
    \Insomnia\Request\RequestValidator,
    \Insomnia\Request\Validator\IntegerValidator,
    \Insomnia\Controller\NotFoundException;

class DeleteAction extends TestController
{
    public function validate()
    {
        $this->validator->required( 'id', new IntegerValidator );
    }

    public function action()
    {
        $doctrine = new Doctrine;
        $result = $doctrine->getManager()->find( 'Application\Entities\Test', $this->validator->getParam( 'id' ) );
        if( !$result ) throw new NotFoundException( 'Entity Not Found' );

        $doctrine->getManager()->remove( $result );
        $doctrine->getManager()->flush();

        $this->response[ 'message' ] = 'Entity Deleted';
    }
}