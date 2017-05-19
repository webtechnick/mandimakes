<?php

namespace App\Traits;

trait Filterable
{
    public function scopeFilter($query, $term)
    {
        $filters = $this->getFilters();
        foreach ($filters as $column) {
            $query->orWhere($column, 'LIKE', "%$term%");
        }
        return $query;
    }

    abstract function getFilters();
}