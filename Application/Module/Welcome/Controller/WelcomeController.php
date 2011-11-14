<?php

namespace Application\Module\Welcome\Controller;

use \Insomnia\Controller\Action,
    \Insomnia\Response,
    \Insomnia\Response\Code,
    \Insomnia\Registry;

/**
 * Welcome Controller
 * 
 * @insomnia:Resource
 * 
 */
class WelcomeController extends Action
{   
    /**
     * Document Root
     * 
     * The default landing page.
     * 
     * @insomnia:Route( "/", name="welcome_index" )
     * @insomnia:Method( "GET" )
     * @insomnia:Documentation( category="Welcome" )
     * 
     * @insomnia:View( "\Application\Module\Welcome\View\Index" )
     * @insomnia:Layout( "\Insomnia\Kernel\Module\Mime\View\Layout" )
     * 
     */
    public function action( \Exception $exception )
    {
    }
}