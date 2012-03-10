<?php

namespace Application\Module\Welcome\Controller;

use \Insomnia\Controller\Action,
    \Insomnia\Response,
    \Insomnia\Response\Code,
    \Insomnia\Registry;

/**
 * Welcome Controller
 * 
 * @Insomnia\Annotation\Resource
 * 
 */
class WelcomeController extends Action
{   
    /**
     * Document Root
     * 
     * The default landing page.
     * 
     * @Insomnia\Annotation\Route( "/", name="welcome_index" )
     * @Insomnia\Annotation\Method( "GET" )
     * @Insomnia\Annotation\Documentation( category="Welcome" )
     * 
     * @Insomnia\Annotation\View( "Application\Module\Welcome\View\Index" )
     * @Insomnia\Annotation\Layout( "Insomnia\Kernel\Module\Mime\View\Layout" )
     * 
     */
    public function action()
    {
    }
}