<?php

namespace Community\Module\Testing\Transport\Debugger\Har;

class Log
{
    public $version = '1.1';
    public $creator;
    public $browser;
    public $comment = '';
    public $pages = array();
    public $entries = array();
    
    /**
     * @param Creator $creator
     * @param Browser $browser 
     */
    public function __construct( Creator $creator, Browser $browser )
    {
        $this->creator = $creator;
        $this->browser = $browser;
    }
    
    /**
     * @param string $comment 
     */
    public function setComment( $comment )
    {
        if( !is_string( $comment ) )
        {
            throw new \UnexpectedValueException( 'Precondition Failed' );
        }
        
        if( strlen( $comment ) )
        {
            $this->comment = $comment;
        }
    }
    
    /**
     * @param Page $page 
     */
    public function addPage( Page $page )
    {
        $this->pages[] = $page;
    }
    
    /**
     * @param Entry $entry 
     */
    public function addEntry( Entry $entry )
    {
        $this->entries[] = $entry;
    }
}
