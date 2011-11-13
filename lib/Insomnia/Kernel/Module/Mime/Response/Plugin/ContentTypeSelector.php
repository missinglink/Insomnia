<?php

namespace Insomnia\Kernel\Module\Mime\Response\Plugin;

use \Insomnia\Pattern\Observer;
use \Insomnia\Registry;

class ContentTypeSelector extends Observer
{
    /* @var $response \Insomnia\Response */
    public function update( \SplSubject $response )
    {
        if( '' === $response->getContentType() )
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
//                case '.rss' : return $response->setContentType( 'application/rss+xml' );
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
                       
//                   case 'application/rss+xml':
//                        return $response->setContentType( 'application/rss+xml' );
                }
            }

            return $response->setContentType( 'application/json' );
        }
    }
}