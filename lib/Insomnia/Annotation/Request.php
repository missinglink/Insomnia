<?php

namespace Insomnia\Annotation;

class Request extends \Insomnia\ArrayAccess
{
    public function __construct( array $data )
    {        
        $this->data = $data;
    }
}