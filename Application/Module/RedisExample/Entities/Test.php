<?php

namespace Application\Module\RedisExample\Entities;

/** @Entity */
class Test
{
    /**
     * @Id @GeneratedValue
     * @Column(type="integer")
     */
    private $id;
    
    /**
     * @Column(type="string",length=50)
     * 
     * @insomnia:Property({
     *      @insomnia:Validate( name="id", type="integer" ),
     *      @insomnia:Validate( name="name", class="\Insomnia\Request\Validator\StringValidator", minlength="4", maxlength="10", optional="true" )
     * })
     */
    private $name;

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
}
