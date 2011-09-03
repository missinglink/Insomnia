<?php

namespace Application\DataMapper;

use \Insomnia\DataMapper;

class Test extends DataMapper
{
    public function export()
    {
        return array(
            'id'    => $this->object->getId(),
            'name'  => $this->object->getName()
        );
    }

    public function import( array $data )
    {
        if( isset( $data['name'] ) )       $this->object->setName( $data[ 'name' ] );
    }
}