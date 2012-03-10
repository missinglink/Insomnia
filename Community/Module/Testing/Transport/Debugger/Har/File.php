<?php

namespace Community\Module\Testing\Transport\Debugger\Har;

class File
{
    public $log;
    
    /**
     * @param Log $log 
     */
    public function __construct( Log $log )
    {
        $this->log = $log;
    }
}
