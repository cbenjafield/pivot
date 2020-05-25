<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $guarded = [];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    protected static function booted()
    {
        static::saving(function ($article) {
            if($article->status == 'published' && empty($article->published_at)) {
                $article->published_at = now();
            }
        });
    }

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
        return $query->where('status', 'published')
                        ->where('published_at', '<=', now()->format('Y-m-d H:i:s'));
    }
}
