<?php

namespace Insomnia\Kernel\Module\HTTP\Controller;

use \Insomnia\Controller\Action,
    \Insomnia\Registry;

/**
 * HTTP OPTIONS method controller
 * 
 * @insomnia:Resource
 * 
 */
class OptionsController extends Action
{
    /**
     * Options
     * 
     * Respond with a 204 No Content to all requests for the OPTIONS HTTP method.
     * 
     * @insomnia:Route("/.*", name="http_options")
     * @insomnia:Method("OPTIONS")
     * 
     * @insomnia:Documentation( title="Options", description="Responds to HTTP OPTIONS requests.", category="HTTP" )
     *
     */
    public function options()
    {
        // Empty Response
        $this->getResponse()->setCode( \Insomnia\Response\Code::HTTP_NO_CONTENT );
    }
}