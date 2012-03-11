<?php

namespace Application\Module\RedisExample\DataMapper;

use \Application\Module\RedisExample\DataMapper;

class Test extends DataMapper
{
    public function export()
    {
        $result[ 'id' ] = $this->object->getId();
        $result[ 'name' ] = $this->object->name;
        
        return $result;
    }

    public function import( array $data )
    {
        if( isset( $data[ 'name' ] ) )
        {
            $this->object->name = $data[ 'name' ];
        }
    }
}