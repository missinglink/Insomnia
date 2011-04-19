<?php

namespace Insomnia;

require_once 'Doctrine/Common/ClassLoader.php';
$classLoader = new \Doctrine\Common\ClassLoader( 'Insomnia' );
$classLoader->register();

$insomnia = new Application;
//$insomnia->showErrors( true );
$insomnia->setRouter( new RestRouter );
$insomnia->run( new Request );