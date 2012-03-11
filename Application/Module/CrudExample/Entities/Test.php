<?php

namespace Application\Module\CrudExample\Entities;

use Doctrine\ORM\Mapping as ORM;

/** @ORM\Entity */
class Test
{
    /**
     * @ORM\Id @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
    
    /**
     * @ORM\Column( type="string", length=50 )
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
