<?php

namespace Insomnia\Response;

use \Insomnia\Response;

abstract class ResponseAbstract
{
    private $response;
    
    /** @return \Insomnia\Response  */
    public function getResponse()
    {
        return $this->response;
    }

    public function setResponse( Response $response )
    {
        $this->response = $response;
    }
}
