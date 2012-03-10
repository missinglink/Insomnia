<?php

namespace Application\Module\RedisExample;

class DataMapper
{
    protected $object;
    
    public function __construct( $object )
    {
        $this->object = $object;
    }
}
