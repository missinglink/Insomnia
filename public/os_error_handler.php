<?php
function os_error_handler( $message )
{
    return( 'error handler triggered' );
    
    $error = error_get_last();
    if( NULL === $error ) return $message;
    else $e = $error[ 'type' ];

    if( !defined( 'PRODUCTION' ) || !PRODUCTION )
    {
        switch( $e )
        {
            case E_ERROR:               $e = 'E_ERROR'; break;
            case E_WARNING:             $e = 'E_WARNING'; break;
            case E_PARSE:               $e = 'E_PARSE'; break;
            case E_NOTICE:              $e = 'E_NOTICE'; break;
            case E_CORE_ERROR:          $e = 'E_CORE_ERROR'; break;
            case E_CORE_WARNING:        $e = 'E_CORE_WARNING'; break;
            case E_COMPILE_ERROR:       $e = 'E_COMPILE_ERROR'; break;
            case E_COMPILE_WARNING:     $e = 'E_COMPILE_WARNING'; break;
            case E_USER_ERROR:          $e = 'E_USER_ERROR'; break;
            case E_USER_WARNING:        $e = 'E_USER_WARNING'; break;
            case E_USER_NOTICE:         $e = 'E_USER_NOTICE'; break;
            case E_STRICT:              $e = 'E_STRICT'; break;
            case E_RECOVERABLE_ERROR:   $e = 'E_RECOVERABLE_ERROR'; break;
            case E_DEPRECATED:          $e = 'E_DEPRECATED'; break;
            case E_USER_DEPRECATED:     $e = 'E_USER_DEPRECATED'; break;
            case E_ALL:                 $e = 'E_ALL'; break;
        }
    }

    $logFilePath = APPLICATION_PATH . DS . 'logs' . DS . 'error.log';

    $debug  = ( date( 'Y-m-d H:i:s' ) . ' - ' . $e . PHP_EOL );
    $debug .= ( "[custom error handler]" . PHP_EOL );
    $debug .= ( "[url]\t\thttp://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . PHP_EOL );
    $debug .= ( "[message]\t" . $error['message'] . PHP_EOL );
    $debug .= ( "[file]\t\t" . $error['file'] . PHP_EOL );
    $debug .= ( "[line]\t\t" . $error['line'] . PHP_EOL );

    file_put_contents( $logFilePath, $debug . PHP_EOL, FILE_APPEND );

    $response = new Api_Response;
    //$error->format( 'pre' );
    $response->setCode( Api_Code::HTTP_INTERNAL_SERVER_ERROR )
             ->set( 'error.message',     'A System Error Occurred. We\'ve Logged it for Review' );

    if( stripos( $error['message'], 'No default module defined for this application' ) !== false )
        $response->setCode( Api_Code::HTTP_NOT_FOUND )
            ->set( 'error.message',     'Invalid Version Specified' );

    return $response->dispatch( true );
}