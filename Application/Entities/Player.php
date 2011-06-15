<?php

namespace Application\Entities;

use \Insomnia\Request\Validator\IntegerValidator,
    \Insomnia\Request\Validator\StringValidator,
    \Insomnia\Request\Validator\EmailValidator;

/**
 * @Entity
 * @Table(name="os_player",
 *      uniqueConstraints={
 *          @UniqueConstraint(name="unique_name",columns={"name"}),
 *          @UniqueConstraint(name="unique_email",columns={"email"})
 *      })
 */
class Player
{
    /**
     * @Id @Column(name="id", type="integer", nullable=false)
     * @GeneratedValue
     */
    private $id;
    
    /**
     * @Column(name="name", type="string", nullable=false)
     */
    private $name;

    /**
     * @Column(name="pass", type="string", length="40", nullable=false)
     */
    private $password;

    /**
     * @Column(name="email", type="string", length="255", nullable=false)
     */
    private $email;

    /**
     * @Column(type="datetime",name="created",nullable=false)
     * @gedmo:Timestampable(on="create")
     */
    private $created;

    /**
     * @Column(type="datetime",name="updated",nullable=false)
     * @gedmo:Timestampable(on="update")
     */
    private $updated;


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

    public function getPassword() {
        return $this->password;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }
    
    public function getCreated() {
        return $this->created;
    }

    public function setCreated($created) {
        $this->created = $created;
    }

    public function getUpdated() {
        return $this->updated;
    }

    public function setUpdated($updated) {
        $this->updated = $updated;
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
        if( isset( $array['name'] ) )       $this->setName( $array[ 'name' ] );
        if( isset( $array['password'] ) )   $this->setPassword( $array[ 'password' ] );
        if( isset( $array['email'] ) )      $this->setEmail( $array[ 'email' ] );
    }
    
    public function validate()
    {
        $validator = new \Insomnia\Validator\EntityValidator( $this );
        $validator->required( 'name',       new StringValidator( 4, 255 ) );
        $validator->required( 'password',   new StringValidator( 4, 255 ) );
        $validator->required( 'email',      new EmailValidator );
        return $validator->validate();
    }
}
