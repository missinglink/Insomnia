<?php

namespace Insomnia\Kernel\Module\Mime\Response\Renderer;

use \Insomnia\Response\ResponseInterface,
    \Insomnia\Response\ResponseAbstract,
    \Insomnia\Response;

class XmlRenderer extends ResponseAbstract implements ResponseInterface
{
    private $writer,
            $indent = '   ';

    public function render()
    {
        $this->writer = new \XMLWriter;

        $this->writer->openURI( 'php://output' );
        $this->writer->startDocument( '1.0', 'UTF-8' );

        $this->writer->setIndent( true );
        $this->writer->setIndentString( $this->indent );

        $this->writer->startElement( 'response' );
        //$this->writer->writeAttribute( 'version', '1.0' );

        $this->writeXML( $this->getResponse()->toArray() );

        $this->writer->endElement();
        $this->writer->endDocument();
        $this->writer->flush();
    }

    private function writeXML( $item )
    {
        foreach( $item as $key => $item )
        {
            if( \is_array( $item ) || \is_object( $item ) )
            {
                $this->writer->startElement( \is_numeric( $key ) ? 'item' : $key );
                $this->writeXML( $item );
                $this->writer->endElement();
                continue;
            }

            if( \is_scalar( $item ) || \is_null( $item ) )
            {
                $this->writer->startElement( \is_numeric( $key ) ? 'item' : $key );
                $this->writer->writeCData( $item );
                $this->writer->endElement();
                continue;
            }
        }
    }

}