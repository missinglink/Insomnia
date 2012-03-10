<?php

namespace Community\Module\Testing\Transport\Debugger;

use \Insomnia\Pattern\Observer,
    \Community\Module\Console\Response\Colourize,
    \Community\Module\Testing\Transport\Transporter;

class CliDebugger extends Observer
{
    const PARSE_RESPONSE = false;
    
    const DEBUG_NONE = 0;
    const DEBUG_SIMPLE = 1;
    const DEBUG_FULL = 2;
    const DEBUG_VERBOSE = 3;
    
    private $renderer;
    private $debugLevel = 0;

    public function __construct( $debugLevel = self::DEBUG_NONE )
    {
        $this->setDebugLevel( $debugLevel );
        $this->setRenderer( new Colourize );
    }

    /* @var $transaction Transporter */
    public function update( \SplSubject $transport )
    {
        if( $this->getDebugLevel() > self::DEBUG_NONE && php_sapi_name() == 'cli' && empty( $_SERVER['REMOTE_ADDR'] ) )
        {
            $this->debugRequest( $transport );
            $this->debugResponse( $transport );
        }
    }
    
    private function output( $string, $foreground = null, $background = null )
    {
        return $this->getRenderer()->getColoredString( $string, $foreground, $background );
    }
    
    private function debugRequest( Transporter $transport )
    {
        echo \PHP_EOL;
        $methodString   = ' ' . $this->output( $transport->getRequest()->getMethod(), 'brown' ) . ' ';
        $protocolString = ' ' . $this->output( $transport->getRequest()->getProtocol(), 'dark_gray' );

        echo $transport->getRequest()->getDomain();
        echo $methodString . $transport->getRequest()->getUri() . ( self::DEBUG_SIMPLE === $this->getDebugLevel() ? $this->output( ' -', 'brown' ) : $protocolString . \PHP_EOL );

        if( self::DEBUG_SIMPLE < $this->getDebugLevel() )
        {
            foreach( $transport->getRequest()->getHeaders() as $headerKey => $headerValue )
            {
                $headerString = '  ' . $this->output( $headerKey . ': ', 'light_blue' );
                echo $this->output( $headerString . $headerValue ) . \PHP_EOL;
            }
            
            echo \PHP_EOL;
        }
        
        if( self::DEBUG_VERBOSE === $this->getDebugLevel() )
        {
            echo $this->output( ' Request Parameters:', 'brown' ) . \PHP_EOL;
            
            foreach( $transport->getRequest()->getParams() as $paramKey => $paramValue )
            {
                $paramString = '  ' . $this->output( $paramKey . ': ', 'light_blue' );
                echo $this->output( $paramString . $paramValue ) . \PHP_EOL;
            }
            
            echo \PHP_EOL;
        }
    }
    
    private function debugResponse( Transporter $transport )
    {
        $protocolString     = ' ' . $this->output( $transport->getResponse()->getProtocol(), 'dark_gray' );
        $responseCodeString = ' ' . $this->output( $transport->getResponse()->getCode(), 'brown' );
        $responseTimeString = ' ' . $this->output( '(' . round( $transport->getResponse()->getExecutionTime() ) . 'ms)', 'light_blue' );

        echo $this->output( ( self::DEBUG_SIMPLE < $this->getDebugLevel() ? $protocolString : '' ) . $responseCodeString . $responseTimeString ) . \PHP_EOL;

        if( self::DEBUG_SIMPLE < $this->getDebugLevel() )
        {            
            foreach( $transport->getResponse()->getHeaders() as $headerKey => $headerValue )
            {
                $headerString = '  ' . $this->output( $headerKey . ': ', 'light_blue' );
                echo $this->output( $headerString . $headerValue ) . \PHP_EOL;
            }
        }

        if( self::DEBUG_VERBOSE === $this->getDebugLevel() )
        {
            echo \PHP_EOL;
            echo $this->output( ' Response:', 'brown' ) . \PHP_EOL;
            
            if( is_string( $transport->getResponse()->getBody() ) && strlen( $transport->getResponse()->getBody() ) < 1000 )
            {
                echo $this->output( str_pad( $transport->getResponse()->getBody(), 120, ' ' ) ) . \PHP_EOL;
            }
            
            else
            {
                echo $this->output( str_pad( substr( $transport->getResponse()->getBody(), 0, 1000 ), 120, ' ' ) ) . \PHP_EOL;
                echo $this->output( str_pad( '... only showing first 1000 chars because content length > 10000 chars', 120, ' ' ), 'brown' ) . \PHP_EOL;
            }

            if( true === self::PARSE_RESPONSE )
            {
                if( strpos( $transport->getResponse()->getHeader( 'Content-Type' ), '/json' ) )
                {
                    $json = json_decode( $transport->getResponse()->getBody(), true );
                    echo $this->output( str_pad( \PHP_EOL . print_r( $json, true ) . \PHP_EOL, 120, ' ' ) ) . \PHP_EOL;
                }
            }
        }
    }
    
    public function getRenderer()
    {
        return $this->renderer;
    }

    public function setRenderer( $renderer )
    {
        $this->renderer = $renderer;
    }
    
    public function getDebugLevel()
    {
        return $this->debugLevel;
    }

    public function setDebugLevel( $debugLevel )
    {
        $this->debugLevel = $debugLevel;
    }
}
