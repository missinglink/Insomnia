<?php

namespace Insomnia\Annotation;

use \Insomnia\Pattern\ArrayAccess;

class Layout extends ArrayAccess
{
    public function __construct( array $data )
    {        
        $this->data = $data;
    }
}