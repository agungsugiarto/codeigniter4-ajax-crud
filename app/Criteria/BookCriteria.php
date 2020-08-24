<?php

namespace App\Criteria;

use Fluent\Repository\Contracts\CriterionInterface;

class BookCriteria implements CriterionInterface
{
    public function apply($entity)
    {
        return $entity->join('status', 'books.status_id = status.id');
    }
}
