<?php

namespace Insomnia\Validator;

/**
 * Database Exception Handler.
 * 
 * Useful to disguise database errors from the user.
 */

class DatabaseException extends \Exception
{
    public function __construct( $message, $code = 0, $previous = null )
    {
        if( $previous instanceof \PDOException )
        {
            if( $previous->getCode() == 23000 && \preg_match( '%key \'unique_(?P<key>.+)\'%', $previous->getMessage(), $match ) )
            {
                throw new \Insomnia\Validator\ErrorStack( array( $match[ 'key' ] => 'unique' ) );
            }
            
            else throw new self( 'Application error' );
        }
    }
}