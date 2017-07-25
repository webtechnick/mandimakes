<?php

namespace App;

use App\Traits\Filterable;
use App\User;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Post extends Model
{
    use Filterable, Sluggable;

    protected $fillable = ['title','slug','body','short_body', 'published_at', 'is_published'];

    protected $dates = ['created_at', 'updated_at', 'published_at'];

    protected $casts = ['is_published' => 'boolean'];

    protected $with = ['author'];

    /**
     * Searchable filters
     * @return [type] [description]
     */
    protected function getFilters()
    {
        return [
            'title','body','id'
        ];
    }

    /**
     * Slug source
     * @return [type] [description]
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * A Post has an author
     * @return [type] [description]
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'user_id')->withDefault();
    }

    /**
     * Published Scope
     * @param  [type] $query [description]
     * @return [type]        [description]
     */
    public function scopePublished($query)
    {
        return $query->where('published_at', '<=', Carbon::today())
                     ->where('is_published', true);
    }

    /**
     * Latest scope should be by published_at, not created.
     * @param  [type] $query [description]
     * @return [type]        [description]
     */
    public function scopeLatest($query)
    {
        return $query->orderBy('published_at', 'desc');
    }

    /**
     * Create a post from form data
     * @param  [type] $data [description]
     * @return [type]       [description]
     */
    public static function createFromRequest($data)
    {
        $post = new self($data);
        $post->published_at = Carbon::parse($data['published_at']);
        $post->user_id = Auth::id();
        if (!$post->short_body) {
            $post->short_body = $post->short();
        }
        $post->save();
        return $post;
    }

    /**
     * Get the most recent post
     * @return [type] [description]
     */
    public static function mostRecent()
    {
        return self::latest()->published()->first();
    }

    /**
     * A Post can be published
     * @return boolean [description]
     */
    public function isActive()
    {
        return $this->is_published;
    }

    /**
     * Decide if the article is considered published.
     * @return boolean [description]
     */
    public function isPublished()
    {
        return $this->published_at->lte(Carbon::now());
    }

    /**
     * A post must be active and published to be viewable
     * @return boolean [description]
     */
    public function isViewable()
    {
        return ($this->isPublished() && $this->isActive());
    }

    /**
     * A Post will have a published class for rendering
     * @return [type] [description]
     */
    public function publishedClass()
    {
        return $this->isActive() ? 'success' : 'danger';
    }

    /**
     * Short desdcription
     * @return [type] [description]
     */
    public function short()
    {
        return str_limit($this->body, 30);
    }

    /**
     * Render the title HTML
     * @return [type] [description]
     */
    public function renderTitle($url = false)
    {
        return "{$this->title} | <small>Published by {$this->author->name} {$this->published_at->diffForHumans()}</small>";
    }

    /**
     * Tpgg;e a posts published boolean flag
     * @return [type] [description]
     */
    public function togglePublished()
    {
        if ($this->isActive()) {
            $this->is_published = false;
        } else {
            $this->is_published = true;
        }

        return $this->save();
    }
}
