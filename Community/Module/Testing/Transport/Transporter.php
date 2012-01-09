<?php

namespace Community\Module\Testing\Transport;

use \Community\Module\Testing\Transport\HTTPRequest;
use \Community\Module\Testing\Transport\HTTPResponse;

interface Transporter
{
    public function execute( HTTPRequest $request, HTTPResponse $response );
    
    public function getRequest();

    public function setRequest( $request );

    public function getResponse();

    public function setResponse( $response );
}