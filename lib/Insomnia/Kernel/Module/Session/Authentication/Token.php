<?php

namespace Insomnia\Kernel\Module\Session\Authentication;

use \Insomnia\Kernel\Module\Session\AuthenticationAbstract,
    \Insomnia\Kernel\Module\Session;

class Token extends AuthenticationAbstract
{
    private $length = 32;
    
    public function __construct()
    {
        \ini_set( 'session.use_cookies',                0 );
        \ini_set( 'session.use_only_cookies',           0 );
        \ini_set( 'session.hash_function',              'crc32' );
    }

    public function authenticate( \Insomnia\Request $request )
    {
        // Request Params
        if( null !== ( $token = $request->getParam( 'token' ) ) && \strlen( $token ) === $this->length )
            Session::useId( $token );

        // Request Header
        else if( \preg_match( '_^Token (?P<token>.{128})$_', $request->getHeader( 'Authorization' ), $match ) )
            Session::useId( $match[ 'token' ] );

        // Create New Session
//        if( Session::get( 'token' ) !== Session::getId() )
//            Session::useId( \bin2hex( \openssl_random_pseudo_bytes( $this->length / 2 ) ) );
    }
}