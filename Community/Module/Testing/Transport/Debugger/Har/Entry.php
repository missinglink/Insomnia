<?php

namespace Community\Module\Testing\Transport\Debugger\Har;

class Entry
{
    public $pageref;
    public $startedDateTime;
    public $time;
    public $request;
    public $response = '';
    public $cache;
    public $timings;
    
    /**
     * @param Page $page
     * @param integer $time
     * @param Request $request
     * @param Response $response 
     * @throws \UnexpectedValueException 
     */
    public function __construct( Page $page, $time, Request $request, Response $response, Cache $cache, Timings $timings )
    {
        if( !is_int( $time ) )
        {
            throw new \UnexpectedValueException( 'Precondition Failed' );
        }
        
        $this->pageref = $page->id;
        $this->startedDateTime = "2010-01-02T15:38:46.686+01:00";
        $this->time = $time;
        $this->request = $request;
        $this->response = $response;
        $this->cache = $cache;
        $this->timings = $timings;
    }
}
