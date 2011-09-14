<?php

namespace Insomnia\Annotation;

use \Insomnia\Pattern\ArrayAccess;

class Param extends ArrayAccess
{
    public function __construct( array $data )
    {        
        $this->data = $data;
    }
}