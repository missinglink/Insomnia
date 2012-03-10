<?php

namespace Insomnia\Annotation;

use \Insomnia\Pattern\ArrayAccess;

/** @Annotation */
class Generic extends ArrayAccess
{
    public function __construct( array $data )
    {        
        $this->data = $data;
    }
}