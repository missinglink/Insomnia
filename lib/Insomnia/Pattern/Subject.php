<?php

namespace Insomnia\Pattern;

abstract class Subject implements \SplSubject
{
    protected $observers;

    public function attach( \SplObserver $observer )
    {
        $this->observers[] = $observer;
    }

    public function detach( \SplObserver $observer )
    {
        if( false !== ( $key = \array_search( $observer, $this->observers ) ) )
        {
            unset( $this->observers[ $key ] );
        }
    }

    public function notify()
    {
        foreach( $this->observers as $observer )
        {
            $observer->update( $this );
        }
    }
}