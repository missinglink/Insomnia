<?php

namespace Insomnia\Pattern;

class PriorityQueue extends \SplPriorityQueue
{
    public function compare($priority1, $priority2)
    {
        if ($priority1 === $priority2) return 0;
        return $priority1 < $priority2 ? -1 : 1;
    }
} 