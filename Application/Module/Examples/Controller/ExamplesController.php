<?php

namespace Application\Module\Examples\Controller;

use \Insomnia\Controller\Action,
    \Insomnia\Response,
    \Insomnia\Response\Code,
    \Insomnia\Registry;

/**
 * Examples Controller
 * 
 * @insomnia:Resource
 * 
 */
class ExamplesController extends Action
{   
    /**
     * Examples Index
     * 
     * @insomnia:Route( "/example", name="Examples_index" )
     * @insomnia:Method( "GET" )
     * 
     * @insomnia:View( "Application\Module\Examples\View\Index" )
     * @insomnia:Layout( "Insomnia\Kernel\Module\Mime\View\Layout" )
     * @insomnia:Documentation( title="Examples Index", description="Examples", category="Examples" )
     *
     */
    public function action()
    {
        $this->response[ 'examples' ] = array(
            array(
                'title' => 'HTML Entities',
                'url' => 'example/entity.html',
                'icon' => '/insomnia/icon/android/ic_menu_text.png'
            ),
            array(
                'title' => 'Crud Example',
                'url' => 'example/crud.html',
                'icon' => '/insomnia/icon/android/ic_menu_save.png',
                'help-text' => 'Requires MYSQL database.',
                'help-uri' => 'example/crud/setup.html',
            )
        );
    }
}