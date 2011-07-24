<?php

namespace Insomnia\Controller;

use \Insomnia\Response;
use \Insomnia\Request\RequestValidator;
use \Insomnia\Registry;

abstract class Action
{
    /* @var $response \Insomnia\Response */
    protected $response;

    /* @var $validator \Insomnia\Request\RequestValidator */
    protected $validator;

    public function __construct()
    {
        $validator = new RequestValidator;       
        $this->setValidator( $validator );
        $this->setResponse( new Response );
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