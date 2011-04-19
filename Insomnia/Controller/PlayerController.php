<?php

namespace Insomnia\Controller;

class PlayerController extends ControllerAbstract implements RestControllerInterface
{
    public function __construct( $request )
    {
        $this->request = $request;
        parent::initView();
    }

    public function create()
    {
        $this->view->message = 'Create';
        $this->view->debug = \print_r( $this->request, true );
        $this->view->render( 'index' );
    }

    public function read( $id )
    {
        $this->view->message = 'Read ' . $id;
        $this->view->debug = \print_r( $this->request, true );
        $this->view->render( 'index' );
    }

    public function update( $id )
    {
        $this->view->message = 'Update ' . $id;
        $this->view->debug = \print_r( $this->request, true );
        $this->view->render( 'index' );
    }

    public function delete( $id )
    {
        $this->view->message = 'Delete ' . $id;
        $this->view->debug = \print_r( $this->request, true );
        $this->view->render( 'index' );
    }

    public function index()
    {
        $this->view->message = 'Index';
        $this->view->debug = \print_r( $this->request, true );
        $this->view->render( 'index' );
    }
}