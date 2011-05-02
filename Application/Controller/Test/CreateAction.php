<?php

namespace Application\Controller\Test;

use \Application\Bootstrap\Doctrine,
    \Application\Controller\TestController,
    \Insomnia\Request\Validator\StringValidator;

class CreateAction extends TestController
{
    public function validate()
    {
        $this->validator->required( 'name', new StringValidator( 4, 10 ) );
    }

    public function action()
    {
        $test = new \Application\Entities\Test;
        $test->setName( $this->validator->getParam( 'name' ) );

        $doctrine = new Doctrine;
        $doctrine->getManager()->persist( $test );
        $doctrine->getManager()->flush();

        $this->response->merge( $test->toArray() );
    }
}