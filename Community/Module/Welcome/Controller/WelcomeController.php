<?php

namespace Community\Module\Welcome\Controller;

use \Insomnia\Response,
    \Insomnia\Response\Code,
    \Insomnia\Registry;

/**
 * Welcome Controller
 * 
 * @insomnia:Resource
 * 
 */
class WelcomeController
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
     * @insomnia:View( "\Community\Module\Welcome\View\Index" )
     * @insomnia:Layout( "\Insomnia\Kernel\Module\Mime\View\Layout" )
     * 
     */
    public function action( \Exception $exception )
    {
        echo( 'welcome' );
    }
}