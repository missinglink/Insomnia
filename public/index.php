<?php

namespace Insomnia;

require_once 'autoloader.php';

// Run Bootstraps
new \Application\Bootstrap\Insomnia;

// Run application
Kernel::getInstance()->run();