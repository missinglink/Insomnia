<?php

namespace Insomnia\Annotation;

class Documentation extends \Insomnia\ArrayAccess
{
    public function __construct( array $data )
    {        
        $this->data = $data;
    }
}