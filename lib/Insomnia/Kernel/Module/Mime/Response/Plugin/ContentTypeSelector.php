<?php

namespace Insomnia\Kernel\Module\Mime\Response\Plugin;

use \Insomnia\Pattern\Observer,
    \Insomnia\Registry,
    \Insomnia\Response,
    \Insomnia\Kernel\Module\Mime\Response\Content;

class ContentTypeSelector extends Observer
{
    /**
     * Sets the response content type based
     * on either the given file extension or
     * the type given in the 'Accept' header
     * 
     * @param Insomnia\Response $response
     * @return void
     */
    public function update( \SplSubject $response )
    {
        if( false == $response->getContentType() )
        {
            switch( Registry::get( 'request' )->getFileExtension() )
            {
                case false  : break;
                case '.json': return $response->setContentType( Content::TYPE_JSON );
                case '.xml' : return $response->setContentType( Content::TYPE_XML );
                case '.html': return $response->setContentType( Content::TYPE_HTML );
                case '.yaml': return $response->setContentType( Content::TYPE_YAML );
                case '.txt' : return $response->setContentType( Content::TYPE_PLAIN );
                case '.ini' : return $response->setContentType( Content::TYPE_INI );
                case '.js':   return $response->setContentType( Content::TYPE_JAVASCRIPT );
                case '.css':  return $response->setContentType( Content::TYPE_CSS );
                case '.swf':  return $response->setContentType( Content::TYPE_SWF );
            }

            foreach( explode( ',', Registry::get( 'request' )->getHeader( 'Accept' ) ) as $format )
            {
                switch( strstr( $format . ';', ';', true ) )
                {
                    case Content::TYPE_JSON:
                        return $response->setContentType( Content::TYPE_JSON );

                    case Content::TYPE_XML:
                    case Content::TYPE_XML_TEXT:
                        return $response->setContentType( Content::TYPE_XML );

                    case Content::TYPE_XHTML:
                    case Content::TYPE_HTML:
                        return $response->setContentType( Content::TYPE_HTML );

                    case Content::TYPE_YAML:
                    case Content::TYPE_YAML_TEXT:
                        return $response->setContentType( Content::TYPE_YAML );

                   case Content::TYPE_PLAIN:
                        return $response->setContentType( Content::TYPE_PLAIN );

                   case Content::TYPE_INI:
                        return $response->setContentType( Content::TYPE_INI );
                       
                   case Content::TYPE_JAVASCRIPT:
                        return $response->setContentType( Content::TYPE_JAVASCRIPT );
                       
                   case Content::TYPE_SWF:
                        return $response->setContentType( Content::TYPE_SWF );
                       
                   case Content::TYPE_CSS:
                        return $response->setContentType( Content::TYPE_CSS );
                }
            }

            // Default content type
            return $response->setContentType( Content::TYPE_JSON );
        }
    }
}