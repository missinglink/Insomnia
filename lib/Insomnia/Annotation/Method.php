<?php

namespace Insomnia\Annotation;

class Method extends \Insomnia\ArrayAccess
{
    public function __construct( array $data )
    {        
        $this->data = $data;
    }
}