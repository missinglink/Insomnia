<?php

namespace Insomnia\Annotation;

class Param extends \Insomnia\ArrayAccess
{
    public function __construct( array $data )
    {        
        $this->data = $data;
    }
}