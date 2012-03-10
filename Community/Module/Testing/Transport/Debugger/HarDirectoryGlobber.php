<?php

namespace Community\Module\Testing\Transport\Debugger;

use \Community\Module\Testing\Transport\Debugger\Har;

class HarDirectoryGlobber
{    
    /**
     * @param string $globPattern
     * @param boolean $mergePages
     * @return \stdClass 
     */
    public function glob( $globPath, $globPattern )
    {
        $directoryIterator = new \GlobIterator( $globPath, \FilesystemIterator::KEY_AS_FILENAME );
        
        $harTestCases = array();

        /* @var $item \SplFileInfo */
        if( $directoryIterator->count() ) foreach( $directoryIterator as $item )
        {
            if( $item->isDir() )
            {
                $harArray = array();
                
                $searchPattern = $item->getRealPath() . \DIRECTORY_SEPARATOR . $globPattern;
                $subdirectoryIterator = new \GlobIterator( $searchPattern, \FilesystemIterator::KEY_AS_FILENAME );
                
                /* @var $item \SplFileInfo */
                if( $subdirectoryIterator->count() ) foreach( $subdirectoryIterator as $item2 )
                {
                    $harArray[] = json_decode( file_get_contents( $item2->getRealPath() ) );
                }
                
                $merger = new HarMerger;
                $harTestCases[] = $merger->merge( $harArray );
            }
        }
        
        $merger = new HarMerger;
        return $merger->merge( $harTestCases, false );
    }
}
