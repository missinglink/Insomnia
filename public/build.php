<?php

define( 'ROOT', dirname( dirname( __FILE__ ) ) . \DIRECTORY_SEPARATOR );

ini_set( 'phar.readonly', 0 );
ini_set( 'error_reporting', 1 );
error_reporting( E_ALL );

//new \Phar( \ROOT . 'public' . \DIRECTORY_SEPARATOR . 'insomnia.phar' , 0, 'insomnia.phar' );
//echo file_get_contents('phar://insomni.phar/lib/Insomnia/Kernel.php');
//var_dump( 'a' );
//die;

$dirs = array(
    \ROOT . 'lib' . \DIRECTORY_SEPARATOR . 'Insomnia',
    \ROOT . 'lib' . \DIRECTORY_SEPARATOR . 'Doctrine',
    \ROOT . 'lib' . \DIRECTORY_SEPARATOR . 'DoctrineExtensions'
);

//$files = array();
//
//foreach( $dirs as $dir )
//{
//    $iterator = new RecursiveDirectoryIterator( $dir );
//
//    /* @var $file \SplFileInfo */
//    foreach( new RecursiveIteratorIterator( $iterator ) as $file )
//    {
//        if( strpos( $file->getFilename() , '.php') )
//        {
//            var_dump( $file->getPath(). \DIRECTORY_SEPARATOR . $file->getFilename() );
//            $files[] = $file->getPath(). \DIRECTORY_SEPARATOR . $file->getFilename();
//        }
//    }
//}

$p = new Phar( \ROOT . 'public' . \DIRECTORY_SEPARATOR . 'insomnia.phar', 0, 'insomnia.phar' );
$p->buildFromDirectory( \ROOT . 'lib' . \DIRECTORY_SEPARATOR . 'Insomnia' );