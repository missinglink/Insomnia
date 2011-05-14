<?php

namespace Application\Controller\Tree;

use \Insomnia\Controller\Action,
    \Insomnia\Registry;

class TreeAction extends Action
{
    public function action()
    {
        $request = Registry::get( 'request' );

        print_r( 'moo' );
        die;
    }
}