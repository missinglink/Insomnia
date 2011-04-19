<?php

namespace Insomnia;

class Request extends Data
{
    public $data = array();
    private $uri = array();

    public function __construct()
    {
        $this->data = \array_merge( $_REQUEST, $this->data );
        $this->uri = \parse_url( $_SERVER['REQUEST_URI'] );
    }

    public function getUri()
    {
        return $this->uri[ 'path' ];
    }

    public function getHost()
    {
        return $this->uri[ 'host' ];
    }

    public function getMethod()
    {
        return \strtoupper( $_SERVER['REQUEST_METHOD'] );
    }
}