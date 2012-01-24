<?php

namespace Community\Module\Documentation\Controller;

use \Insomnia\Controller\Action;
use \Insomnia\Annotation\Parser\Route as RouteParser;
use \Insomnia\Annotation\Parser\ParamParser;
use \Insomnia\Annotation\Parser\Documentation;
use \Insomnia\Router\AnnotationReader;
use \Insomnia\Router\RouteStack;
use \Insomnia\Registry;
use \Insomnia\Pattern\ArrayAccess;
use \Insomnia\Kernel;

/**
 * WebService Documentation
 * 
 * @insomnia:Resource
 * 
 */
class DocumentationController extends Action
{
    /**
     * Documentation Index
     * 
     * @insomnia:Route( "/doc", name="doc_index" )
     * @insomnia:Method( "GET" )
     * @insomnia:View( "Community\Module\Documentation\View\Index" )
     * @insomnia:Layout( "Insomnia\Kernel\Module\Mime\View\Layout" )
     * @insomnia:Documentation( title="Documentation Index", description="WebService Documentation", category="Documentation" )
     *
     */
    public function index()
    {
        $this->getResponse()->merge( array(
            'directory' => array (
                'modules' => Registry::get( 'request' )->getUri() . '/modules',
                'routes' => Registry::get( 'request' )->getUri() . '/routes'
            )
        ) );
    }
    
    /**
     * List Modules
     * 
     * @insomnia:Route( "/doc/modules", name="doc_modules" )
     * @insomnia:Method( "GET" )
     * @insomnia:View( "Community\Module\Documentation\View\Modules" )
     * @insomnia:Layout( "Insomnia\Kernel\Module\Mime\View\Layout" )
     * @insomnia:Documentation( title="List Modules", description="List Modules", category="Documentation" )
     *
     */
    public function modules()
    {
        foreach( Kernel::getInstance()->getModules() as $moduleInstance )
        {
            $moduleClass = get_class( $moduleInstance );
            
            $reader = new AnnotationReader( $moduleClass );
            $reflectionMethod  = $reader->getReflector()->getMethod( 'run' );
            $methodAnnotations = $reader->getMethodAnnotations( $reflectionMethod );

            $moduleName = reset( array_slice( explode( '\\', $moduleClass ), -2, 1 ) );
            
            $this->getResponse()->set( $moduleName, array() );
            
            foreach( $methodAnnotations as $annotation )
            {
                if( \get_class( $annotation ) == 'Insomnia\Annotation\KernelPlugins' )
                {
                    foreach( $annotation[ 'value' ] as $value )
                    {
                        $annotationName = end( explode( '\\', get_class( $value ) ) );
                        
                        $this->getResponse()->set( $moduleName,
                            array_merge_recursive( $this->getResponse()->get( $moduleName ), array( $annotationName => array( $value->get( 'class' ) ) ) )
                        );
                    }
                }
            }
        }
    }
    
    /**
     * List Routes
     * 
     * @insomnia:Route( "/doc/routes", name="doc_routes" )
     * @insomnia:Method( "GET" )
     * @insomnia:View( "Community\Module\Documentation\View\Routes" )
     * @insomnia:Layout( "Insomnia\Kernel\Module\Mime\View\Layout" )
     * @insomnia:Documentation( title="List Routes", description="List Routes", category="Documentation" )
     *
     */
    public function routes()
    {
        $routes = new ArrayAccess;
        $doc = array();
        
        foreach( Kernel::getInstance()->getEndPoints() as $controllerClass )
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
                $a[ 'patternRegex' ] = $route->getpatternRegex();
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