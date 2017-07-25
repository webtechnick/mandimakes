<?php

namespace App;

use App\Photo;
use Illuminate\Database\Eloquent\Model;

class Charity extends Model
{
    protected $fillable = ['name','description','url'];

    public function photo()
    {
        return $this->belongsTo(Photo::class)->withDefault();
    }
}
