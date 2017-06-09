<?php

namespace App;

use App\Events\TagDeleting;
use App\Item;
use App\Traits\Filterable;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use Sluggable, Filterable;

    protected $fillable = [
        'name', 'slug'
    ];

    protected $events = [
        'deleting' => TagDeleting::class
    ];

    protected function getFilters()
    {
        return ['name','slug'];
    }

    /**
     * Slug source
     * @return [type] [description]
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }
    /**
     * A Tag has many items.
     * @return [type] [description]
     */
    public function items()
    {
        return $this->belongsToMany(Item::class);
    }
}
