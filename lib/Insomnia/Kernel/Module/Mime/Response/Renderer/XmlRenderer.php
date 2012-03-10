<?php

namespace Insomnia\Kernel\Module\Mime\Response\Renderer;

use \Insomnia\Response\ResponseInterface,
    \Insomnia\Response\ResponseAbstract,
    \Insomnia\Response;

class XmlRenderer extends ResponseAbstract implements ResponseInterface
{
    const INDENT_STRING = '   ';
    const MAX_RECURSION = 20;
    const NUMERIC_KEY_REPLACEMENT = 'item'; // Replace numeric keys with this string.
    private $debugLevel = 0;
    
    private $writer;

    public function render()
    {
        $this->writer = new \XMLWriter;

        $this->writer->openURI( 'php://output' );
        $this->writer->startDocument( '1.0', 'UTF-8' );

        $this->writer->setIndent( true );
        $this->writer->setIndentString( self::INDENT_STRING );

        $this->writer->startElement( 'response' );
        //$this->writer->writeAttribute( 'version', '1.0' );

        $this->setDebugLevel( \APPLICATION_ENV === 'development' ? 2 : 0 );
        $this->writeXML( $this->getResponse()->toArray() );
        
        $this->writer->endElement();
        $this->writer->endDocument();
        $this->writer->flush();
    }

    private function writeXML( $item, $level = 0 )
    {
        if( (bool) $this->getDebugLevel() && $level > self::MAX_RECURSION )
        {
            return $this->writer->writeCData( '{ error: max recursion reached }' );
        }
        
        foreach( $item as $key => $item )
        {
            // XML keys cannot start with a number or contain spaces.
            $key = ( is_numeric( $key ) ? self::NUMERIC_KEY_REPLACEMENT : str_replace( ' ', '_', $key ) );
            
            // Validate element name
            if( $this->getDebugLevel() > 1 )
            {
                new \DOMElement( $key );
            }
            
            if( is_array( $item ) || is_object( $item ) )
            {
                $this->writer->startElement( $key );
                $this->writeXML( $item, $level++ );
                $this->writer->endElement();
            }

            else if( is_scalar( $item ) || is_null( $item ) )
            {
                $this->writer->startElement( $key );
                $this->writer->writeCData( $item );
                $this->writer->endElement();
            }
            
            else if( (bool) $this->getDebugLevel() )
            {
                return $this->writer->writeCData( '{ error: cannot render object of type '. gettype( $item ) .' }' );
            }
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