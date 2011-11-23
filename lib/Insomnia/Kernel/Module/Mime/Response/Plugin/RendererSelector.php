<?php

namespace Insomnia\Kernel\Module\Mime\Response\Plugin;

use \Insomnia\Pattern\Observer,
    \Insomnia\Registry,
    \Insomnia\Kernel\Module\Mime\Response\Renderer,
    \Insomnia\Kernel\Module\Mime\Response\Content;

class RendererSelector extends Observer
{
    /**
     * Set the reponse renderer based on the content type
     * 
     * @var $response \Insomnia\Response
     */
    public function update( \SplSubject $response )
    {
        if( null === $response->getRenderer() )
        {
            switch( $response->getContentType() )
            {
                case Content::TYPE_XML:
                case Content::TYPE_XML_TEXT:
                    $response->setRenderer( new Renderer\XmlRenderer );
                    break;

                case Content::TYPE_YAML:
                case Content::TYPE_YAML_TEXT:
                    $response->setRenderer( new Renderer\YamlRenderer );
                    break;

                case Content::TYPE_HTML:
                case Content::TYPE_XHTML:
                    $response->setRenderer( new Renderer\ViewRenderer );
                    break;

                case Content::TYPE_PLAIN:
                    $response->setRenderer( new Renderer\ArrayRenderer );
                    break;

                case Content::TYPE_INI:
                    $response->setRenderer( new Renderer\IniRenderer );
                    break;
                
                default:
                    $response->setRenderer( new Renderer\JsonRenderer );
                    break;
            }
        }
    }
}