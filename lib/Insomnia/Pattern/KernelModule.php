<?php

namespace Insomnia\Pattern;

use \Insomnia\Kernel;

abstract class KernelModule
{
    abstract public function bootstrap( Kernel $kernel );
}