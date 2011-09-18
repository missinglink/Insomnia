<?php

namespace Insomnia\Kernel\Module\Mime\Response\Plugin;

use \Insomnia\Pattern\Observer;
use \Insomnia\Registry;

use \Insomnia\Kernel\Module\Mime\Response\Renderer\XmlRenderer,
    \Insomnia\Kernel\Module\Mime\Response\Renderer\JsonRenderer,
    \Insomnia\Kernel\Module\Mime\Response\Renderer\ViewRenderer,
    \Insomnia\Kernel\Module\Mime\Response\Renderer\ArrayRenderer,
    \Insomnia\Kernel\Module\Mime\Response\Renderer\YamlRenderer,
    \Insomnia\Kernel\Module\Mime\Response\Renderer\IniRenderer;

class RendererSelector extends Observer
{
    /* @var $response \Insomnia\Response */
    public function update( \SplSubject $response )
    {
        if( null === $response->getRenderer() )
        {
            switch( \strstr( $response->getContentType(), '/' ) )
            {
                case '/xml':
                    $response->setRenderer( new XmlRenderer );
                    break;

                case '/x-yaml': case '/yaml':
                    $response->setRenderer( new YamlRenderer );
                    break;

                case '/xhtml': case '/html':
                    $response->setRenderer( new ViewRenderer );
                    break;

                case '/plain':
                    $response->setRenderer( new ArrayRenderer );
                    break;

                case '/ini':
                    $response->setRenderer( new IniRenderer );
                    break;
                
                case '/json':
                default:
                    $response->setRenderer( new JsonRenderer );
                    break;
            }
        }
    }
}