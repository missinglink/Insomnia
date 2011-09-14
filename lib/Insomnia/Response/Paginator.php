<?php

namespace Insomnia\Response;

use \DoctrineExtensions\Paginate\PaginationAdapter,
    \Doctrine\ORM\Query;

class Paginator extends PaginationAdapter
{
    private $pageSize = 100,
            $currentPage = 1;

    public function __construct( $query, $ns = 'pgid' )
    {
        if( \method_exists( $query, 'getQuery' ) )
            $query = $query->getQuery();

        parent::__construct( $query, $ns );
    }
    
    public function getItems($offset = null, $itemCountPerPage = null)
    {
        return parent::getItems( ( $this->currentPage -1 ) * $this->pageSize, $this->pageSize );
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
