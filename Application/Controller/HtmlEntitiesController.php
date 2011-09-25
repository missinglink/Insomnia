<?php

namespace Application\Controller;

use \Insomnia\Controller\Action,
    \Application\Bootstrap\Doctrine,
    \Application\Controller\TestController,
    \Insomnia\Request\Validator\IntegerValidator,
    \Insomnia\Request\Validator\StringValidator,
    \Insomnia\Controller\NotFoundException,
    \Insomnia\Response\Paginator,
    \Application\Queries\TestQuery;

use \Insomnia\Kernel\Module\RequestValidator\Request\RequestValidator;

use \Application\DataMapper\Test as DataMapper;

/**
 * Test Create Action
 * 
 * @insomnia:Resource
 * 
 */
class HtmlEntitiesController extends Action
{    
    /**
     * Html Entities (domain root)
     * 
     * @insomnia:Route( "/", name="entity_root" )
     * @insomnia:Method( "GET" )
     * @insomnia:Documentation( category="Application" )
     *
     * @insomnia:View( "\Application\View\Entities" )
     * @insomnia:Layout( "\Insomnia\Kernel\Module\Mime\View\Layout" )
     * 
     */
    public function index()
    {
        return $this->multiple();
    }
    
    /**
     * Html Entities
     * 
     * @insomnia:Route( "/entity", name="entity_multiple" )
     * @insomnia:Method( "GET" )
     * @insomnia:Documentation( category="Application" )
     *
     * @insomnia:View( "\Application\View\Entities" )
     * @insomnia:Layout( "\Application\View\EntityLayout" )
     * 
     */
    public function multiple()
    {
        $entities = $this->getEntities();
        
        $this->response->setTimeToLive( 31556926 );
        
        $this->response->merge( $entities );
    }
    
    /**
     * Html Entity
     * 
     * @insomnia:Route( "/entity/:id", name="entity_single" )
     * @insomnia:Method( "GET" )
     * @insomnia:Documentation( category="Application" )
     *
     * @insomnia:Request({
     *      @insomnia:Param( name="id", type="string" )
     * })
     * 
     * @insomnia:View( "\Application\View\Entity" )
     * @insomnia:Layout( "\Application\View\EntityLayout" )
     * 
     */
    public function single()
    {
        $entities = $this->getEntities();
        
        $this->response->setTimeToLive( 31556926 );
        
        if( isset( $entities[ $this->validator->getParam( 'id' ) ] ) )
        {
            $this->response->merge( $entities[ $this->validator->getParam( 'id' ) ] );
        }
        
        else throw new \Insomnia\Router\RouterException( 'Failed to Match any Routes' );
    }
    
//    /**
//     * Html Entity
//     * 
//     * @insomnia:Route( "/entity/:id/:prop", name="entity_info" )
//     * @insomnia:Method( "GET" )
//     * @insomnia:Documentation( category="Application" )
//     *
//     * @insomnia:Request({
//     *      @insomnia:Param( name="id", type="string" ),
//     *      @insomnia:Param( name="prop", type="string", optional="true" )
//     * })
//     * 
//     * @insomnia:View( "\Application\View\Raw" )
//     * 
//     */
//    public function singleRaw()
//    {
//        $entities = $this->getEntities();
//        
//        $allowedSearchKeys = array_keys( reset( $entities ) );
//        if( in_array( $this->validator->getParam( 'prop' ), $allowedSearchKeys ) )
//        {
//        
//            if( isset( $entities[ $this->validator->getParam( 'id' ) ] ) )
//            {
//                $this->response->merge( array( $entities[ $this->validator->getParam( 'id' ) ][ $this->validator->getParam( 'prop' ) ] ) );
//            }
//
//            else throw new \Insomnia\Router\RouterException( 'Failed to Match any Routes' );
//            
//        }
//        
//        else throw new \Insomnia\Router\RouterException( 'Failed to Match any Routes' );
//    }
    
    private function getEntities( $header = false )
    {
        $file = trim( file_get_contents( __DIR__ . DIRECTORY_SEPARATOR . 'htmlentities.txt' ) );
        $e = explode( PHP_EOL, $file );
        
        $entityMap = array();
        
        foreach( $e as $num => $line )
        {
            $fe = explode( "\t", $line );

            // Strip wikipedia annotation tags
            $fe = array_map( function( $element ) {
                return preg_replace( "#\[\d+\]#", '', $element );
            }, $fe );
                
            $fe = array_map( 'trim', $fe );
            $fe = array_map( 'strip_tags', $fe );
         
            // add keys
            foreach( $fe as $k => $v )
            {
                switch( $k )
                {
                    case 0 :
                        $fe[ 'name' ] = $v;
                        $fe[ 'uri' ] = ( isset( $_SERVER['HTTPS'] ) ? 'https' : 'http' ) . '://' . $_SERVER['HTTP_HOST'] . '/entity/' . $v;
                        break;
                    case 1 :
                        $fe[ 'character' ] = $v;
                        $fe[ 'htmlentity' ] = htmlentities( $v, ENT_COMPAT, 'UTF-8' );
                        $fe[ 'ascii' ] = ord( $v );
                        break;
                    case 2 :
                        $fe[ 'unicode' ] = $v;
                        break;
                    case 3 :
                        $fe[ 'standard' ] = $v;
                        break;
                    case 4 :
                        $fe[ 'dtd' ] = $v;
                        break;
                    case 5 :
                        $fe[ 'subset' ] = $v;
                        break;
                    case 6 :
                        $fe[ 'description' ] = $v;
                        break;                    
                }
                
                unset( $fe[ $k ] );
            }
            
            $entityMap[ $fe[ 'name' ] ] = $fe;
        }
        
        if( false == $header )
        {
            $headers = array_shift( $entityMap ); // Remove the header
        }
        
        return $entityMap;
    }
}