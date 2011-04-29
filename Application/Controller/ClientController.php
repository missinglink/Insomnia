<?php

namespace Application\Controller;

use \Application\Bootstrap\Doctrine,
    \Insomnia\Session,
    \Insomnia\Request\Validator,
    \Insomnia\Response\Format\ViewRenderer,
    \Insomnia\Controller\NotFoundException,
    \Insomnia\Controller\ControllerAbstract;

class ClientController extends ControllerAbstract
{
    public function __construct()
    {
        parent::__construct();
        
        $renderer = new ViewRenderer;
        $renderer->setLayoutPath( dirname( __DIR__ ) . '/Layout' );
        $renderer->setViewPath  ( dirname( __DIR__ ) . '/View' );
        $renderer->useView( 'client/index' );
        
        $this->response->setRenderer( $renderer );
    }

    public function create()
    {
    }

    public function index()
    {        
        //$doctrine = new Doctrine;
        //$results = $doctrine->getManager()->getRepository( 'Application\Entities\Test' )->findAll();
    }

    public function read()
    {
        $this->response->getRenderer()->useView( 'client/index' );
    }

    public function update()
    {
    }

    public function delete()
    {
    }
}