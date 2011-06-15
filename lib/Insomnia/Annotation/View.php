<?php

namespace Insomnia\Annotation;

class View extends \Insomnia\ArrayAccess
{
    public function __construct( array $data )
    {        
        $this->data = $data;
    }
}