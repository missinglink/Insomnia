<?php

namespace Community\Module\Testing\Transport\Debugger;

use \Community\Module\Testing\Transport\Debugger\Har;

class HarMerger
{
    public function merge( $harArray, $mergePages = true )
    {
        $returnHar = new \stdClass;
        
        foreach( $harArray as $key => $har )
        {
            // Basic validity check
            if( !isset( $har->log ) )
            {
                continue;
            }
            
            if( $key === 0 )
            {
                $returnHar = $har;

                continue;
            }

            if( $mergePages )
            {
                foreach( $har->log->entries as $entry )
                {
                    $entry->pageref = $returnHar->log->pages[ 0 ]->id;
                    $returnHar->log->pages[ 0 ]->pageTimings->onLoad += (int) $entry->time;
                }
            }

            else
            {
                $returnHar->log->pages = array_merge( $returnHar->log->pages, $har->log->pages );
            }

            $returnHar->log->entries = array_merge( $returnHar->log->entries, $har->log->entries );
        }
        
        return $returnHar;
    }
}
