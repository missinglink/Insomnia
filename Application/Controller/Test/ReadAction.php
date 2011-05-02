<?php

namespace Application\Controller\Test;

use \Application\Bootstrap\Doctrine,
    \Application\Controller\TestController,
    \Insomnia\Request\Validator\IntegerValidator,
    \Insomnia\Request\Validator\StringValidator,
    \Insomnia\Controller\NotFoundException;

class ReadAction extends TestController
{
    public function validate()
    {
        $this->validator->required( 'id',     new IntegerValidator );
        $this->validator->optional( 'name',   new StringValidator( 1, 10 ) );
    }

    public function action()
    {
        $doctrine    = new Doctrine;
        $result = $doctrine->getManager()->find( 'Application\Entities\Test', $this->validator->getParam( 'id' ) );
        if( !$result ) throw new NotFoundException( 'Entity Not Found' );

        $this->response->merge( $result->toArray() );
    }
}