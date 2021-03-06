<?php

namespace Community\Module\EasyXDM\Controller;

use \Insomnia\Controller\Action,
    \Insomnia\Controller\NotFoundException;

/**
 * EasyXDM Controller
 * 
 * Cross-Domain messaging made easy
 * 
 * @Insomnia\Annotation\Resource
 * 
 */
class EasyXDMController extends Action
{
    private $viewPath = '';
    
    public function __construct()
    {
        parent::__construct();
        $this->viewPath = dirname( __DIR__ ) . \DIRECTORY_SEPARATOR . 'View' . \DIRECTORY_SEPARATOR . 'easyXDM' . \DIRECTORY_SEPARATOR;
    }
    
    /**
     * EasyXDM Example
     * 
     * Cross-Domain messaging made easy
     * 
     * @Insomnia\Annotation\Route("/xdm/example", name="xdm_example")
     * @Insomnia\Annotation\Method("GET")
     * @Insomnia\Annotation\Documentation( category="Cross-Domain Messaging" )
     * 
     * @Insomnia\Annotation\View( "Community\Module\EasyXDM\View\Example" )
     * @Insomnia\Annotation\Layout( "Insomnia\Kernel\Module\Mime\View\Layout" )
     * 
     */
    public function example()
    {
        $this->response->setContentType( 'text/html' );
    }
    
    /**
     * EasyXDM Library Index
     * 
     * Cross-Domain messaging made easy
     * 
     * @Insomnia\Annotation\Route("/xdm/hash", name="xdm_index")
     * @Insomnia\Annotation\Method("GET")
     * @Insomnia\Annotation\Documentation( category="Cross-Domain Messaging" )
     * 
     * @Insomnia\Annotation\View( "Community\Module\EasyXDM\View\Hash" )
     * 
     */
    public function hash()
    {
        $this->response->setContentType( 'text/html' );
    }
    
    /**
     * EasyXDM Library Name File
     * 
     * Cross-Domain messaging made easy
     * 
     * @Insomnia\Annotation\Route("/xdm/name", name="xdm_name")
     * @Insomnia\Annotation\Method("GET")
     * @Insomnia\Annotation\Documentation( category="Cross-Domain Messaging" )
     * 
     * @Insomnia\Annotation\View( "Community\Module\EasyXDM\View\Name" )
     * 
     */
    public function name()
    {
        $this->response->setContentType( 'text/html' );
    }
    
    /**
     * EasyXDM Library Javascript Library
     * 
     * Cross-Domain messaging made easy
     * 
     * @Insomnia\Annotation\Route("/xdm/easyXDM", name="xdm_lib")
     * @Insomnia\Annotation\Method("GET")
     * @Insomnia\Annotation\Documentation( category="Cross-Domain Messaging" )
     * 
     */
    public function library()
    {
        $libPath = $this->viewPath . 'easyXDM.min.js';
        
        if( !file_exists( $libPath ) || !is_readable( $libPath ) )
        {
            throw new NotFoundException( 'File Not Found' );
        }
        
        $this->getResponse()->replace( file_get_contents( $libPath ) );
    }
    
    /**
     * Json2 Javascript Library
     * 
     * @Insomnia\Annotation\Route("/xdm/json2", name="xdm_json2")
     * @Insomnia\Annotation\Method("GET")
     * @Insomnia\Annotation\Documentation( category="Cross-Domain Messaging" )
     * 
     */
    public function json2()
    {
        $libPath = $this->viewPath . 'json2.min.js';
        
        if( !file_exists( $libPath ) || !is_readable( $libPath ) )
        {
            throw new NotFoundException( 'File Not Found' );
        }
        
        $this->getResponse()->replace( file_get_contents( $libPath ) );
    }
    
    /**
     * EasyXDM Compatibility SWF
     * 
     * Cross-Domain messaging made easy
     * 
     * @Insomnia\Annotation\Route("/xdm/flash", name="xdm_flash")
     * @Insomnia\Annotation\Method("GET")
     * @Insomnia\Annotation\Documentation( category="Cross-Domain Messaging" )
     * 
     */
    public function swf()
    {
        $libPath = $this->viewPath . 'easyXDM.swf';
        
        if( !file_exists( $libPath ) || !is_readable( $libPath ) )
        {
            throw new NotFoundException( 'File Not Found' );
        }
        
        $this->getResponse()->replace( file_get_contents( $libPath ) );
    }
}