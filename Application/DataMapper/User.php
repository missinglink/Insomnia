<?php

namespace Application\DataMapper;

use \Insomnia\DataMapper;

class User extends DataMapper
{
    public function export()
    {
        return array(
            'id'    => $this->object->getId(),
            'name'  => $this->object->getName(),
            'email' => $this->object->getEmail()
        );
    }

    public function import( array $data )
    {
        if( isset( $data['name'] ) )       $this->object->setName( $data[ 'name' ] );
        if( isset( $data['email'] ) )      $this->object->setName( $data[ 'email' ] );
    }
}