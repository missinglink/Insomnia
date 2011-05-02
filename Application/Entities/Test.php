<?php

namespace Application\Entities;

/** @Entity */
class Test
{
    /**
     * @Id @Column(type="integer")
     * @GeneratedValue
     */
    private $id;
    
    /** @Column(length=50) */
    private $name; // type defaults to string

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function toArray()
    {
        $a = array();
        $a[ 'id' ]      = $this->getId();
        $a[ 'name' ]    = $this->getName();
        return $a;
    }

    public function fromArray( $array )
    {
        if( array_key_exists( 'name', $array ) ) $this->setName( $array[ 'name' ] );
    }
}
