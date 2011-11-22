<?php

namespace Insomnia\Kernel\Module\Mime\Response\Plugin;

use \Insomnia\Pattern\Observer;
use \Insomnia\Registry;
use \Insomnia\Response;

class ContentTypeSelector extends Observer
{
    /**#@+
     * Supported mime types
     * @const string
     */
    const TYPE_HTML      = 'text/html',
          TYPE_INI       = 'text/ini',
          TYPE_JSON      = 'application/json',
          TYPE_PLAIN     = 'text/plain',
          TYPE_RSS       = 'application/rss+xml',
          TYPE_XHTML     = 'application/xhtml',
          TYPE_XML       = 'application/xml',
          TYPE_XML_TEXT  = 'text/xml',
          TYPE_YAML      = 'application/x-yaml',
          TYPE_YAML_TEXT = 'text/yaml';
    /**#@-*/
    
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
                case '.json': return $response->setContentType( self::TYPE_JSON );
                case '.xml' : return $response->setContentType( self::TYPE_XML );
                case '.html': return $response->setContentType( self::TYPE_HTML );
                case '.yaml': return $response->setContentType( self::TYPE_YAML );
                case '.txt' : return $response->setContentType( self::TYPE_PLAIN );
                case '.ini' : return $response->setContentType( self::TYPE_INI );
            }

            foreach( explode( ',', Registry::get( 'request' )->getHeader( 'Accept' ) ) as $format )
            {
                switch( strstr( $format . ';', ';', true ) )
                {
                    case self::TYPE_JSON:
                        return $response->setContentType( self::TYPE_JSON );

                    case self::TYPE_XML:
                    case self::TYPE_XML_TEXT:
                        return $response->setContentType( self::TYPE_XML );

                    case self::TYPE_XHTML:
                    case self::TYPE_HTML:
                        return $response->setContentType( self::TYPE_HTML );

                    case self::TYPE_YAML:
                    case self::TYPE_YAML_TEXT:
                        return $response->setContentType( self::TYPE_YAML );

                   case self::TYPE_PLAIN:
                        return $response->setContentType( self::TYPE_PLAIN );

                   case self::TYPE_INI:
                        return $response->setContentType( self::TYPE_INI );
                }
            }

            // Default content type
            return $response->setContentType( self::TYPE_JSON );
        }
    }
}