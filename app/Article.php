<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $guarded = [];

    public function site()
    {
        return $this->belongsTo(Site::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function parent()
    {
        return $this->belongsTo(Article::class);
    }

    public function meta()
    {
        return $this->hasMany(Meta::class);
    }

    public function scopeRoot(Builder $query)
    {
        return $query->whereNull('parent_id');
    }

    public function scopePublished(Builder $query)
    {
        return $query->where('status', 'publish')
                        ->where('published_at', '>=', now()->format('Y-m-d H:i:s'));
    }
}
