<?php

namespace Insomnia\Controller;

use \Insomnia\Request,
    \Insomnia\Response,
    \Insomnia\Request\RequestValidator;

abstract class Action
{
    protected $request,
              $response,
              $validator;

    public function __construct()
    {
        $this->setResponse( new Response );
    }

    public function validate(){}
    public function action(){}
    public function render(){}
    
    public function getRequest()
    {
        return $this->request;
    }

    public function setRequest( Request $request )
    {
        $this->request = $request;
        $this->setValidator( new RequestValidator( $this->request ) );
    }

    public function getResponse()
    {
        return $this->response;
    }

    public function setResponse( $response )
    {
        $this->response = $response;
    }

    public function getValidator()
    {
        return $this->validator;
    }

    public function setValidator( $validator )
    {
        $this->validator = $validator;
    }
}