<?php

namespace Insomnia;

class DataMapper
{
    protected $object;
    
    public function __construct( $object )
    {
        $this->object = $object;
    }
}
