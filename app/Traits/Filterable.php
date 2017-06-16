<?php

namespace App\Traits;

trait Filterable
{

    /**
     * Define getFilters in your model that's using this trait
     * It should return an array of columns
     * @return [array] single dim array of columns to search
     */
    abstract function getFilters();

    /**
     * Adding where statements based on the column filters given to us by getFitlers()
     * @param  [type] $query [description]
     * @param  [type] $term  [description]
     * @return [type]        [description]
     */
    public function scopeFilter($query, $term)
    {
        $filters = $this->getFilters();
        if (empty($filters)) {
            return $query;
        }
        $query->where(function($query) use ($term, $filters){
            foreach ($filters as $column) {
                $query->orWhere($column, 'LIKE', "%$term%");
            }
        });
        return $query;
    }
}