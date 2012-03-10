<?php

namespace Community\Module\Testing\Transport\Debugger\Har;

class Page
{
    public $startedDateTime;
    public $id;
    public $title;
    public $pageTimings;
    public $comment = '';
    
    /**
     * @param string $title
     * @param PageTrimmings $pageTrimmings 
     * @throws \UnexpectedValueException 
     */
    public function __construct( $title, PageTimings $pageTimings )
    {
        if( !is_string( $title ) )
        {
            throw new \UnexpectedValueException( 'Precondition Failed' );
        }
        
        $this->startedDateTime = "2010-01-02T15:38:46.686+01:00";
        $this->id = 'page_' . mt_rand( 1, \PHP_INT_MAX );
        $this->title = $title;
        $this->pageTimings = $pageTimings;
    }
    
    /**
     * @param string $comment 
     */
    public function setComment( $comment )
    {
        if( is_string( $comment ) && strlen( $comment ) )
        {
            $this->comment = $comment;
        }
    }
}
