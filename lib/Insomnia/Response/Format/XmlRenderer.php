<?php

namespace Insomnia\Response\Format;

use \Insomnia\Response\ResponseInterface,
    \Insomnia\Response;

class XmlRenderer implements ResponseInterface
{
    private $writer,
            $indent = '   ';
    
    public function render( Response $response )
    {
        $this->writer = new \XMLWriter;

        $this->writer->openURI( 'php://output' );
        $this->writer->startDocument( '1.0' );

        $this->writer->setIndent( true );
        $this->writer->setIndentString( $this->indent );

        $this->writer->startElement( 'response' );
        $this->writer->writeAttribute( 'version', '1.0' );

        $this->writeXML( $response->toArray() );
        
        $this->writer->endElement();
        $this->writer->endDocument();
        $this->writer->flush();
    }

    private function writeXML( $item )
    {
        foreach( $item as $key => $item )
        {
            if( is_array( $item ) )
            {
                $this->writer->startElement( is_numeric( $key ) ? 'item' : $key );
                $this->writeXML( $item );
                $this->writer->endElement();
                continue;
            }

            $this->writer->writeElement( $key, $item );
        }
    }
  
}