<?php

namespace Insomnia\Response;

use \Insomnia\Response;

interface ResponseInterface
{
    public function render();
    
    /** @return \Insomnia\Response  */
    public function getResponse();

    public function setResponse( Response $response );
}
