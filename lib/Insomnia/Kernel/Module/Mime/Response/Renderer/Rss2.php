<?php

namespace Insomnia\Kernel\Module\Mime\Response\Renderer;

use \Insomnia\Response\ResponseInterface,
    \Insomnia\Response\ResponseAbstract,
    \Insomnia\Response;

class Rss2 extends ResponseAbstract implements ResponseInterface
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

            $this->writer->startElement( 'rss' );
            $this->writer->writeAttribute( 'version', '2.0' );

                $this->writer->startElement( 'channel' );

                    //title
                    //link
                    //description
                    //language
                    //copyright
                    //pubDate
                    //generator
                
                    $this->writeXML( $this->getResponse()->toArray() );

                $this->writer->endElement();

            $this->writer->endElement();
            
        $this->writer->endDocument();
        $this->writer->flush();
    }

    private function writeXML( $item )
    {
        foreach( $item as $key => $item )
        {
            if( \is_array( $item ) )
            {
                $this->writer->startElement( 'item' );
                
                $this->writer->startElement( 'title' );
                    $this->writer->writeRaw( $item[ 'title' ] );
                $this->writer->endElement();
                
                if( isset( $item[ 'uri' ] ) )
                {
                    $this->writer->startElement( 'link' );
                        $this->writer->writeRaw( $item[ 'uri' ] );
                    $this->writer->endElement();
                }
                
                if( isset( $item[ 'description' ] ) )
                {
                    $this->writer->startElement( 'description' );
                        $this->writer->writeRaw( $item[ 'description' ] );
                    $this->writer->endElement();
                }
                
                $this->writeXML( $item );
                $this->writer->endElement();
                continue;
            }
        }
    }

}