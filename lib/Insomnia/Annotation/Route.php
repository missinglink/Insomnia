<?php

namespace Insomnia\Annotation;

use \Insomnia\Pattern\ArrayAccess;

class Route extends ArrayAccess
{
    public function __construct( array $data )
    {        
        $this->data = $data;
    }
}