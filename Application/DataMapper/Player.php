<?php

namespace Application\DataMapper;

use \Insomnia\DataMapper;

class Player extends DataMapper
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
        if( isset( $data['password'] ) )   $this->object->setPassword( $data[ 'password' ] );
        if( isset( $data['email'] ) )      $this->object->setEmail( $data[ 'email' ] );
    }
}