<?php

namespace Application\Entities;

/**
 * @Entity
 * @Table(name="os_user",
 *      uniqueConstraints={
 *          @UniqueConstraint(name="unique_name",columns={"name"}),
 *          @UniqueConstraint(name="unique_email",columns={"email"})
 *      })
 */
class User
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
     *      @insomnia:Validate( name="id", type="integer" )
     * })
     */
    private $name;
    
    /**
     * @Column(type="string",length=50,nullable=true)
     * 
     * @insomnia:Property({
     *      @insomnia:Validate( name="name", class="\Insomnia\Request\Validator\StringValidator", minlength="4", maxlength="10", optional="true" )
     * })
     */
    private $email;

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
    
    public function getEmail() {
        return $this->email;
    }

    public function setEmail( $email )
    {
        $this->email = $email;
    }
}
