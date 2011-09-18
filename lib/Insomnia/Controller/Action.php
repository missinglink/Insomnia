<?php

namespace Insomnia\Controller;

use \Insomnia\Response;
use \Insomnia\Registry;

use \Insomnia\Kernel\Module\RequestValidator\Request\RequestValidator;

abstract class Action
{
    /* @var $response \Insomnia\Response */
    protected $response;

    /* @var $validator \Insomnia\Kernel\Module\RequestValidator\Request\RequestValidator */
    protected $validator;

    public function __construct()
    {
        $validator = new RequestValidator;
        $this->setValidator( $validator );
        $this->setResponse( new Response );
    }

    /**
     * @return \Insomnia\Response 
     */
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