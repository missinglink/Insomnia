<?php

namespace Application\Controller;

use \Insomnia\Controller\Action;
use \Insomnia\Annotation\Parser\Route as RouteParser;
use \Insomnia\Annotation\Parser\ParamParser;
use \Insomnia\Annotation\Parser\Documentation;
use \Insomnia\Router\AnnotationReader;
use \Insomnia\Router\RouteStack;
use \Insomnia\Registry;

/**
 * WebService Documentation
 * 
 * @webservice:Resource
 * 
 */
class DocumentationController extends Action
{       
    /**
     * List Endpoints
     * 
     * @webservice:Route( "/doc", name="documentation" )
     * @webservice:Method( "GET")
     * @webservice:View( "documentation/index" )
     * @webservice:Documentation( title="Documentation", description="List Endpoints", category="System" )
     * 
     * @webservice:Request({
     *      @webservice:Param( name="id", type="integer", optional="true" ),
     *      @webservice:Param( name="page", type="integer", optional="true" )
     * })
     *
     */
    public function index()
    {        
        $routes = new \Insomnia\ArrayAccess;
        $validations = new \Insomnia\ArrayAccess;
        $doc = array();
        
        foreach( Registry::get( 'router' )->getClasses() as $controllerClass )
        {
            $reader = new AnnotationReader( $controllerClass );
            $routes = new RouteParser( $reader );
            
            foreach( $routes->toArray() as $route )
            {
                /* @var $reflectionMethod ReflectionMethod */
                $reflectionMethod = $route->getReflectionMethod();
                
                $docBlock = \preg_replace( '#[ \t]*(?:\/\*\*|\*\/|\*)?[ ]{0,1}(.*)?#', '$1', $reflectionMethod->getDocComment() );
                $docBlock = \preg_replace( '#(.*@.*)#', '', $docBlock );
                $docBlock = \trim( $docBlock, "({}) \n\t" );
                
                $a[ 'title' ] = \trim( substr( $docBlock, 0, $pos = \strpos( $docBlock . "\n", "\n" ) ) );
                $a[ 'description'  ] = \trim( \str_replace( "\n", ' ',substr( $docBlock, $pos ) ) );
                
                $docs = new Documentation( $reader->getMethodAnnotations( $reflectionMethod ) );
                if( $docs['title'] ) $a['title'] = $docs['title'];
                if( $docs['description'] ) $a['description'] = $docs['description'];
                
                $category = isset( $docs['category'] ) ? $docs['category'] : 'Uncategorized';
                $a[ 'category' ] = $category;
                $a[ 'pattern' ] = $route->getPattern();
                $a[ 'methods' ] = $route->getMethods();
                
                $params = new ParamParser( $reader->getMethodAnnotations( $reflectionMethod ) );
                $a[ 'params' ] = $params->toArray();
                
                if( !isset( $doc[ $category ] ) ) $doc[ $category ] = array();
                $doc[ $category ][] = $a;
            }
        }
        
        \ksort( $doc );
        $this->getResponse()->merge( $doc );
    }
}