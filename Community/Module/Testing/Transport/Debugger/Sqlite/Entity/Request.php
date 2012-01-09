<?php

namespace Community\Module\Testing\Transport\Debugger\Sqlite\Entity;

/** @Entity */
class Request
{
    /**
     * @Id @GeneratedValue
     * @Column(type="integer")
     */
    private $id;
     
    /**
     * @Column(type="string",length=50)
     */
    private $content;
    
    /**
     * @return int 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id 
     */
    public function setId( $id )
    {
        $this->id = $id;
    }

    /**
     * @return string 
     */
    public function getContent()
    {
        return $this->content;
    }
    
    /**
    * @param string $content 
    */
    public function setContent( $content )
    {
        $this->content = $content;
    }
}