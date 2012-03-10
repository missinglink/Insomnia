<?php

namespace Community\Module\Testing\Transport\Cli;

class CurlVerboseLogParser
{
    const TIMESTAMP_PATTERN = '[0-9:\.]{15}';
    private $stdout;
    
    /**
     * @param string $stdout 
     */
    public function __construct( $stdout )
    {
        $this->stdout = $stdout;
    }
    
    public function filterByDelimiter( $delimeter )
    {
        return preg_grep( '_^'.self::TIMESTAMP_PATTERN.' ' . $delimeter . ' (.*)$_', $this->stdout );
    }
    
    private function parseLine( $logLine )
    {
        $matches = array();
        
        if( !preg_match( '_^(?P<timestamp>'.self::TIMESTAMP_PATTERN.') (?P<delimeter>[\*<>]{1}) (?P<body>.*)$_', $logLine, $matches ) )
        {
            throw new \Exception( 'Could not parse log line' );
        }
        
        $line = new \stdClass;
        $line->timestamp = (string) $matches[ 'timestamp' ];
        $line->delimeter = (string) $matches[ 'delimeter' ];
        $line->body      = (string) $matches[ 'body' ];
        
        return $line;
    }
    
    private function formatDatetime( $logTimestamp )
    {
        if( !preg_match( '_^(?P<hour>[0-9]{2}):(?P<min>[0-9]{2}):(?P<sec>[0-9]{2})\.(?P<micro>[0-9]{1,6})$_', $logTimestamp, $parsed ) )
        {
            throw new \Exception( 'Failed to parse timestamp: "' . $logTimestamp . '"' );
        }
        
        $sum = (int) $parsed[ 'micro' ];
        $sum += (int) $parsed[ 'sec' ] * 1000000;
        $sum += (int) $parsed[ 'min' ] * 1000000 * 60;
        $sum += (int) $parsed[ 'hour' ] * 1000000 * 60 * 60;
        
        return (int) $sum;
    }
    
    public function getStats()
    {
        $stats = new \stdClass;
        $stats->start           = $this->formatDatetime( $this->parseLine( reset( $this->stdout ) )->timestamp );
        $stats->requestStart    = $this->formatDatetime( $this->parseLine( reset( $this->filterByDelimiter( '>' ) ) )->timestamp );
        $stats->requestEnd      = $this->formatDatetime( $this->parseLine( end( $this->filterByDelimiter( '>' ) ) )->timestamp );
        $stats->responseStart   = $this->formatDatetime( $this->parseLine( reset( $this->filterByDelimiter( '<' ) ) )->timestamp );
        $stats->responseEnd     = $this->formatDatetime( $this->parseLine( end( $this->filterByDelimiter( '<' ) ) )->timestamp );
        $stats->end             = $this->formatDatetime( $this->parseLine( end( $this->stdout ) )->timestamp );
        
        return $stats;
    }
    
    public function getTraceSection()
    {
        $requestSection = array();
        
        foreach( $this->filterByDelimiter( '*' ) as $logLine )
        {
            $parsed = $this->parseLine( $logLine );
            $requestSection[] = $parsed->body;
        }
        
        return $requestSection;
    }
    
    public function getRequestSection()
    {
        $requestSection = array();
        
        foreach( $this->filterByDelimiter( '>' ) as $logLine )
        {
            $parsed = $this->parseLine( $logLine );
            $requestSection[] = $parsed->body;
        }
        
        return $requestSection;
    }
    
    public function getResponseSection()
    {
        $responseSection = array();
        
        foreach( $this->filterByDelimiter( '<' ) as $logLine )
        {
            $parsed = $this->parseLine( $logLine );
            $responseSection[] = $parsed->body;
        }
        
        return $responseSection;
    }
}
