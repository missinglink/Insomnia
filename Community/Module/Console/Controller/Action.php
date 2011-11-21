<?php

namespace Community\Module\Console\Controller;

use \Insomnia\Controller\Action as BaseAction,
    \Community\Module\Console\Response\Colourize;

abstract class Action extends BaseAction
{
    private $multiplier = 100;
    private $maxColumns = 80;
    private $maxRows    = 60;
    
    public function __construct()
    {
        parent::__construct();
        
        $this->colorize = new Colourize;
        $this->getCliDimensions();
        
        $this->setMultiplier( $this->getMaxColumns() );
    }
    
    public function getCliDimensions()
    {
        $fp=popen("resize", "r");
        $b=stream_get_contents($fp);
        preg_match("/COLUMNS=([0-9]+)/", $b, $matches);$columns = $matches[1];
        preg_match("/LINES=([0-9]+)/", $b, $matches);$rows = $matches[1];
        pclose($fp);
        
        $this->setMaxColumns( $columns );
        $this->setMaxRows( $rows );
    }
    
    public function outputTitle()
    {
        echo PHP_EOL;
        echo $this->colorize->getColoredString( str_repeat( '+', $this->getMultiplier() ), 'dark_gray' ) . PHP_EOL;
        
        $lines = explode( PHP_EOL, file_get_contents( __DIR__ . '/../View/logo.txt' ) );
        //print_r( $lines );
        
        foreach( $lines as $line )
        {
            echo $this->colorize->getColoredString( str_pad( $line, $this->getMultiplier(), ' ' ), 'yellow' ) . PHP_EOL;
        }
        
        echo $this->colorize->getColoredString( str_repeat( '+', $this->getMultiplier() ), 'dark_gray' ) . PHP_EOL;
        echo PHP_EOL;
    }
    
    public function outputString( $line, $fg = 'green' )
    {
        echo $this->colorize->getColoredString( str_pad( $line, $this->getMultiplier(), ' ' ), $fg ) . PHP_EOL;
    }
    
    public function getMultiplier()
    {
        return $this->multiplier;
    }

    public function setMultiplier( $multiplier )
    {
        $this->multiplier = $multiplier;
    }
    
    public function outputHeader( $title, $char = ' ' )
    {
        echo $this->colorize->getColoredString( '+', 'white' );
        echo $this->colorize->getColoredString( ' ' . $title . ' ', $this->getMultiplier(), 'white' );
        echo $this->colorize->getColoredString( str_repeat( '.', $this->getMultiplier() - strlen( $title ) - 3 ), 'dark_gray' ) . PHP_EOL;
        
        //echo $this->colorize->getColoredString( str_pad( ' ' . $title . ' ', $this->getMultiplier(), $char ), 'white', 'blue' ) . PHP_EOL;
        echo PHP_EOL;
    }
    
    public function outputLine( $char = '_' )
    {
        echo str_repeat( $char, $this->getMultiplier() ) . PHP_EOL;
    }
    
    public function getMaxColumns()
    {
        return $this->maxColumns;
    }

    public function setMaxColumns( $maxColumns )
    {
        $this->maxColumns = $maxColumns;
    }

    public function getMaxRows()
    {
        return $this->maxRows;
    }

    public function setMaxRows( $maxRows )
    {
        $this->maxRows = $maxRows;
    }
}