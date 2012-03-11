<?php

namespace Application\Module\RedisExample\DataMapper;

use \Application\Module\RedisExample\DataMapper;

class Test extends DataMapper
{
    public function export()
    {
        return array(
            'id'    => $this->object->getId(),
            'name'  => $this->object->name
        );
    }

    public function import( array $data )
    {
        if( isset( $data['name'] ) )       $this->object->name = $data[ 'name' ];
    }
}