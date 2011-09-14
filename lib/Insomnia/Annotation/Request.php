<?php

namespace Insomnia\Annotation;

use \Insomnia\Pattern\ArrayAccess;

class Request extends ArrayAccess
{
    public function __construct( array $data )
    {        
        $this->data = $data;
    }
}