<?php

namespace Insomnia\Response\Plugin;

use \Insomnia\Pattern\Observer;
use \Insomnia\Registry;

use \Insomnia\Response\Renderer\XmlRenderer,
    \Insomnia\Response\Renderer\JsonRenderer,
    \Insomnia\Response\Renderer\ViewRenderer,
    \Insomnia\Response\Renderer\ArrayRenderer,
    \Insomnia\Response\Renderer\YamlRenderer,
    \Insomnia\Response\Renderer\IniRenderer;

class RendererSelector extends Observer
{
    /* @var $response \Insomnia\Response */
    public function update( \SplSubject $response )
    {
        if( null === $response->getRenderer() )
        {
            switch( \strstr( $response->getContentType(), '/' ) )
            {
                case '/json':
                    $response->setRenderer( new JsonRenderer );
                    break;

                case '/xml':
                    $response->setRenderer( new XmlRenderer );
                    break;

                case '/x-yaml': case '/yaml':
                    $response->setRenderer( new YamlRenderer );
                    break;

                case '/xhtml': case '/html':
                    $renderer = new ViewRenderer;
                    $renderer->useView( Registry::get( 'dispatcher' )->getController() . '/' . Registry::get( 'dispatcher' )->getAction() );
                    $response->setRenderer( $renderer );
                    break;

                case '/plain':
                    $response->setRenderer( new ArrayRenderer );
                    break;

                case '/ini':
                    $response->setRenderer( new IniRenderer );
                    break;

                default: if( $this->controller === 'errors' )
                {
                    $response->setContentType( Registry::get( 'default_content_type' ) );
                    $renderer->useView( Registry::get( 'dispatcher' )->getController() . '/' . Registry::get( 'dispatcher' )->getAction() );
                }
            }
        }
    }
}