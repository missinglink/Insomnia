<?php

namespace Application\Module\CrudExample;

class DataMapper
{
    protected $object;
    
    public function __construct( $object )
    {
        $this->object = $object;
    }
}
