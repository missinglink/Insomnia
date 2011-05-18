<?php

namespace Insomnia\Response\Plugin;

use \Insomnia\Pattern\Observer;
use \Insomnia\Registry;

class ContentTypeSelector extends Observer
{
    /* @var $request \Insomnia\Response */
    public function update( \SplSubject $response )
    {
        if( null === $response->getContentType() )
        {
            switch( Registry::get( 'request' )->getFileExtension() )
            {
                case false  : break;
                case '.json': return $response->setContentType( 'application/json' );
                case '.xml' : return $response->setContentType( 'application/xml' );
                case '.html': return $response->setContentType( 'text/html' );
                case '.yaml': return $response->setContentType( 'application/x-yaml' );
                case '.txt' : return $response->setContentType( 'text/plain' );
                case '.ini' : return $response->setContentType( 'text/ini' );
            }

            foreach( \explode( ',', Registry::get( 'request' )->getHeader( 'Accept' ) ) as $format )
            {
                switch( \strstr( $format . ';', ';', true ) )
                {
                    case 'application/json':
                        return $response->setContentType( 'application/json' );

                    case 'application/xml':
                    case 'text/xml':
                        return $response->setContentType( 'application/xml' );

                    case 'application/xhtml':
                    case 'text/html':
                        return $response->setContentType( 'text/html' );

                    case 'application/x-yaml':
                    case 'text/yaml':
                        return $response->setContentType( 'application/x-yaml' );

                   case 'text/plain':
                        return $response->setContentType( 'text/plain' );

                   case 'text/ini':
                        return $response->setContentType( 'text/ini' );
                }
            }

            $response->setContentType( Registry::get( 'default_content_type' ) );
        }
    }
}