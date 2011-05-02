<?php

namespace Application\Controller\Test;

use \Application\Bootstrap\Doctrine,
    \Application\Controller\TestController,
    \Insomnia\Request\RequestValidator,
    \Insomnia\Request\Validator\IntegerValidator,
    \Insomnia\Request\Validator\StringValidator,
    \Insomnia\Controller\NotFoundException;

class UpdateAction extends TestController
{
    public function validate()
    {
        $this->validator->required( 'id',     new IntegerValidator );
        $this->validator->optional( 'name',   new StringValidator( 1, 10 ) );
    }

    public function action()
    {
        $doctrine = new Doctrine;
        $result = $doctrine->getManager()->find( 'Application\Entities\Test', $this->request['id'] );
        if( !$result ) throw new NotFoundException( 'Entity Not Found' );

        $result->fromArray( $this->validator->getParams() );
        $doctrine->getManager()->persist( $result );
        $doctrine->getManager()->flush();

        $this->response->merge( $result->toArray() );
    }
}