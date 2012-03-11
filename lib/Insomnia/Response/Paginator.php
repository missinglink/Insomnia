<?php

namespace Insomnia\Response;

use \Pagerfanta\Adapter\DoctrineORMAdapter,
    \Doctrine\ORM\Query;

class Paginator extends DoctrineORMAdapter
{
    private $pageSize = 100,
            $currentPage = 1;

    public function __construct( $query )
    {
        if( \method_exists( $query, 'getQuery' ) )
            $query = $query->getQuery();

        parent::__construct( $query );
    }
    
    public function getItems( $offset = null, $itemCountPerPage = null )
    {
        return parent::getSlice( ( $this->currentPage -1 ) * $this->pageSize, $this->pageSize );
    }

    public function getPageSize()
    {
        return $this->pageSize;
    }

    public function setPageSize( $pageSize )
    {
        $this->pageSize = is_numeric( $pageSize ) ? $pageSize : 100;
    }

    public function getCurrentPage()
    {
        return $this->currentPage;
    }

    public function setCurrentPage( $currentPage )
    {
        $this->currentPage = is_numeric( $currentPage ) ? $currentPage : 1;
    }
}
