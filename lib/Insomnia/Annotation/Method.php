<?php

namespace Insomnia\Annotation;

use \Insomnia\Pattern\ArrayAccess;

class Method extends ArrayAccess
{
    public function __construct( array $data )
    {        
        $this->data = $data;
    }
}