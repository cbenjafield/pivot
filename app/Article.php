<?php

namespace App;

use App\Pivot\Facades\Theme;
use App\Traits\DisplaysContent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use DisplaysContent;
    
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
            $article->makeUrl();
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
        return $this->belongsTo(Article::class, 'parent_id');
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

    public function url()
    {
        if(is_null($this->url)) {
            $this->makeUrl();
        }
        return $this->url;
    }

    public function makeUrl()
    {
        if(request('website') && $this->id == request('website')->home_page_id) {
            return '/';
        }

        $parents = $this->parents->toArray();

        $parentParts = [];

        foreach($parents as $parent) {
            $parentParts[] = $parent['slug'];
        }

        $parentParts[] = $this->slug;

        // dd($parentParts);

        $url = implode('/', $parentParts);

        $this->url = $url;
    }

    public function getParentsAttribute()
    {
        $collection = collect([]);
        $parent = $this->parent;
        while($parent) {
            $collection->push($parent);
            $parent = $parent->parent;
        }
        return $collection->reverse();
    }

    public function requestIsHomePage()
    {
        return $this->id === request('website')->home_page_id;
    }

    public function view()
    {
        return Theme::view(
            ($this->type == 'page' ? 'page' : 'post'),
            [
                'article' => $this,
                'website' => request('website')
            ]
        );
    }

    public function scopeSearch(Builder $query, $request)
    {
        $term = $request->term;

        return 
            $query->where(function ($where) use ($term) {
                $where->where('title', 'LIKE', "%{$term}%")
                            ->orWhere('slug', 'LIKE', "%{$term}%");
            })
            ->when($request->parent, function ($when, $parent) {
                $when->whereNotIn('id', [$parent]);
            })
            ->when($request->article, function ($when, $article) {
                $when->whereNotIn('id', [$article]);
            });
    }
}
