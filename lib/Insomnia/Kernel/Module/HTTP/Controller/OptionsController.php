<?php

namespace Insomnia\Kernel\Module\HTTP\Controller;

use Insomnia\Controller\Action,
    Insomnia\Registry;

/**
 * HTTP OPTIONS method controller
 * 
 * @Insomnia\Annotation\Resource
 * 
 */
class OptionsController extends Action
{
    /**
     * Options
     * 
     * Respond with a 204 No Content to all requests for the OPTIONS HTTP method.
     * 
     * @Insomnia\Annotation\Route( "/.*", name="http_options" )
     * @Insomnia\Annotation\Method( "OPTIONS" )
     * 
     * @Insomnia\Annotation\Documentation( title="Options", description="Responds to HTTP OPTIONS requests.", category="HTTP" )
     *
     */
    public function options()
    {
        // Empty Response
        $this->getResponse()->setCode( \Insomnia\Response\Code::HTTP_NO_CONTENT );
    }
}