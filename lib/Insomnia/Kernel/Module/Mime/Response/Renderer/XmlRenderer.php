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

        $this->writeXML( $this->getResponse()->toArray() );

        $this->writer->endElement();
        $this->writer->endDocument();
        $this->writer->flush();
    }

    private function writeXML( $item, $level = 0 )
    {
        if( $level > self::MAX_RECURSION )
        {
            return $this->writer->writeCData( '{ error: max recursion reached }' );
        }
        
        foreach( $item as $key => $item )
        {
            // XML keys cannot start with a number.
            $xmlKeyFix = is_numeric( $key ) ? self::NUMERIC_KEY_REPLACEMENT : $key;
            
            if( is_array( $item ) || is_object( $item ) )
            {
                $this->writer->startElement( $xmlKeyFix );
                $this->writeXML( $item, $level++ );
                $this->writer->endElement();
            }

            if( is_scalar( $item ) || is_null( $item ) )
            {
                $this->writer->startElement( $xmlKeyFix );
                $this->writer->writeCData( $item );
                $this->writer->endElement();
            }
        }
    }

}