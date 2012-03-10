<?php

namespace Community\Module\Testing\Transport\Debugger\Har;

class PageTimings
{
    public $onContentLoad;
    public $onLoad;
    
    /**
     * @param integer $onContentLoad
     * @param integer $onLoad
     * @throws \UnexpectedValueException 
     */
    public function __construct( $onContentLoad, $onLoad )
    {
        if( !is_int( $onContentLoad ) || !is_int( $onLoad ) )
        {
            throw new \UnexpectedValueException( 'Precondition Failed' );
        }
        
        $this->onContentLoad = $onContentLoad;
        $this->onLoad = $onLoad;
    }
}
