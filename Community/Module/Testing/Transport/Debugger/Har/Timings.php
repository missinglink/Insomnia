<?php

namespace Community\Module\Testing\Transport\Debugger\Har;

class Timings extends \stdClass
{
    public $dns = 0;
    public $connect = 0;
    public $blocked = 0;
    public $send = 0;
    public $wait = 0;
    public $receive = 0;
    
    /**
     * @param integer $stats
     */
    public function __construct( \stdClass $stats )
    {
        self::merge( $this, $stats );
    }
    
    public static function merge( \stdClass $timings, \stdClass $stats )
    {
        if( isset( $stats->start, $stats->requestStart, $stats->requestEnd, $stats->responseStart, $stats->responseEnd, $stats->end ) )
        {
            $timings->dns      = 0;
            $timings->connect  = floor( ( ( (int) $stats->requestStart    - (int) $stats->start ) /1000 ) +0.5 );
            $timings->blocked  = floor( ( ( (int) $stats->end             - (int) $stats->responseEnd ) /1000 ) +0.5 );
            $timings->send     = floor( ( ( (int) $stats->requestEnd      - (int) $stats->requestStart ) /1000 ) +0.5 );
            $timings->wait     = floor( ( ( (int) $stats->responseStart   - (int) $stats->requestEnd ) /1000 ) +0.5 );
            $timings->receive  = floor( ( ( (int) $stats->responseEnd     - (int) $stats->responseStart ) /1000 ) +0.5 );
        }
    }
    
    public function getTotal()
    {
        return array_sum( array( $this->dns, $this->connect, $this->blocked, $this->send, $this->wait, $this->receive ) );
    }
}
