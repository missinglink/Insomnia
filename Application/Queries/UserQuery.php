<?php

namespace Application\Queries;

use \Doctrine\ORM\QueryBuilder,
    \Doctrine\ORM\EntityManager,
    \DoctrineExtensions\Paginate\PaginationAdapter;

class UserQuery extends QueryBuilder
{
    public function __construct( EntityManager $em )
    {
        parent::__construct( $em );

        $this->select('u');
        $this->from( 'Application\Entities\User', 'u' );
    }
}