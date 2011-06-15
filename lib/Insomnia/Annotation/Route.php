<?php

namespace Insomnia\Annotation;

class Route extends \Insomnia\ArrayAccess
{
    public function __construct( array $data )
    {        
        $this->data = $data;
    }
}