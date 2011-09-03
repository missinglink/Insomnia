<?php

namespace Insomnia\Pattern;

use \Insomnia\Kernel;

abstract class Component
{
    abstract public function bootstrap( Kernel $kernel );
}