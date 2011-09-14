<?php

namespace Insomnia\Kernel\Module\Documentation\Controller;

use \Insomnia\Controller\Action;
use \Insomnia\Annotation\Parser\Route as RouteParser;
use \Insomnia\Annotation\Parser\ParamParser;
use \Insomnia\Annotation\Parser\Documentation;
use \Insomnia\Router\AnnotationReader;
use \Insomnia\Router\RouteStack;
use \Insomnia\Registry;
use \Insomnia\Pattern\ArrayAccess;

/**
 * WebService Documentation
 * 
 * @insomnia:Resource
 * 
 */
class DocumentationController extends Action
{       
    /**
     * List Endpoints
     * 
     * @insomnia:Route( "/doc", name="documentation" )
     * @insomnia:Method( "GET" )
     * @insomnia:View( "../View/documentation/index.php" )
     * @insomnia:Documentation( title="Documentation", description="List Endpoints", category="System" )
     * 
     * @insomnia:Request({
     *      @insomnia:Param( name="id", type="integer", optional="true" ),
     *      @insomnia:Param( name="page", type="integer", optional="true" )
     * })
     *
     */
    public function index()
    {
        $routes = new ArrayAccess;
        $validations = new ArrayAccess;
        $doc = array();
        
        foreach( \Insomnia\Kernel::getInstance()->getEndPoints() as $controllerClass )
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