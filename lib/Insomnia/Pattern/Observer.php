<?php

namespace Insomnia\Pattern;

abstract class Observer implements \SplObserver
{
    public function update( SplSubject $subject )
    {}
}