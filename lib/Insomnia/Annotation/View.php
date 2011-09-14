<?php

namespace Insomnia\Annotation;

use \Insomnia\Pattern\ArrayAccess;

class View extends ArrayAccess
{
    public function __construct( array $data )
    {        
        $this->data = $data;
    }
}