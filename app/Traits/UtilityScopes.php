<?php

namespace App\Traits;

trait UtilityScopes {

    public function scopeGetField($query, $field)
    {
        return $query->select($field)->first()->$field;
    }
}