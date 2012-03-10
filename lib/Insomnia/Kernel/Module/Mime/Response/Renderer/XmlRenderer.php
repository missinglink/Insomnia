<?php

namespace Insomnia\Kernel\Module\Mime\Response\Renderer;

use \Insomnia\Response\ResponseInterface,
    \Insomnia\Response\ResponseAbstract,
    \Insomnia\Response;

class XmlRenderer extends ResponseAbstract implements ResponseInterface
{
    const INDENT_STRING = '   ';
    const MAX_RECURSION = 50;
    const ROOT_ELEMENT_NAME = 'response';
    const NUMERIC_KEY_REPLACEMENT = 'item'; // Replace numeric keys with this string.
    
    const DEBUG_NONE = 0;
    const DEBUG_OUTPUT = 1;
    const DEBUG_VALIDATE = 2;
    
    private $debugLevel = self::DEBUG_NONE;
    private $writer;

    public function render()
    {
        $this->writer = new \XMLWriter;
        
        $this->writer->openMemory();
        $this->writer->startDocument( '1.0', 'UTF-8' );

            $this->writer->setIndent( true );
            $this->writer->setIndentString( self::INDENT_STRING );

            $this->writer->startElement( self::ROOT_ELEMENT_NAME );
            
                //$this->writer->writeAttribute( 'version', '1.0' );
                $this->setDebugLevel( \APPLICATION_ENV === 'development' ? self::DEBUG_VALIDATE : self::DEBUG_NONE );
                $this->writeXML( $this->getResponse()->toArray() );

            $this->writer->endElement();
            
        $this->writer->endDocument();
        
        print $this->writer->outputMemory( false );
    }

    private function writeXML( $item, $level = 0 )
    {
        foreach( $item as $key => $item )
        {
            if( is_array( $item ) || is_object( $item ) )
            {
                // Prevent recursing too deeply.
                if( $level < self::MAX_RECURSION )
                {
                    $this->writer->startElement( $this->getValidXMLElementName( $key ) );
                    $this->writeXML( $item, $level++ );
                    $this->writer->endElement();
                }
                
                else $this->debug( 'max recursion reached' );
            }

            else if( is_scalar( $item ) || is_null( $item ) )
            {
                $this->writer->startElement( $this->getValidXMLElementName( $key ) );
                $this->writer->writeCData( $item );
                $this->writer->endElement();
            }
            
            else $this->debug( 'cannot render object of type '. gettype( $item ) );
        }
    }
    
    private function getValidXMLElementName( $key )
    {
        // XML keys cannot start with a number or contain spaces.
        $key = ( is_numeric( $key ) ? self::NUMERIC_KEY_REPLACEMENT : str_replace( ' ', '_', $key ) );

        // Validate element name
        if( $this->getDebugLevel() === self::DEBUG_VALIDATE )
        {
            // DOMElement throws and exception if the $key is invalid
            new \DOMElement( $key );
        }
        
        return $key;
    }
    
    private function debug( $message = 'XML Renderer Failed', $level = 1 )
    {
        if( $level >= $this->getDebugLevel() )
        {
            $this->writer->startElement( 'error' );
            $this->writer->writeCData( $message  );
            $this->writer->endElement();
        }
    }

    /**  @return integer  */
    public function getDebugLevel()
    {
        return (int) $this->debugLevel;
    }

    /** @param integer $debugLevel */
    public function setDebugLevel( $debugLevel )
    {
        $this->debugLevel = $debugLevel;
    }
}