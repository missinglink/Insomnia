<?php

namespace Insomnia\Controller;

use \Insomnia\Response,
    \Insomnia\Request\RequestValidator,
    \Insomnia\Registry;

abstract class Action
{
    protected $response,
              $validator;

    public function __construct()
    {
        $this->setValidator( new RequestValidator );
        $this->setResponse( new Response );
    }

    public function validate(){}
    public function action(){}
    public function render(){}

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