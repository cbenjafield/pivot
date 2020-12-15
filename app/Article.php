<?php

namespace App;

use App\Articles\Meta;
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

    protected $appends = [
        'full_url',
    ];

    protected static function booted()
    {
        static::saving(function ($article) {
            if($article->status == 'published' && empty($article->published_at)) {
                $article->published_at = now();
            }
            if(! in_array($article->status, ['deleted'])) {
                $article->makeUrl();
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

    public function scopePage(Builder $query)
    {
        return $query->whereIn('type', ['page']);
    }

    public function scopePost(Builder $query)
    {
        return $query->whereIn('type', ['post']);
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

    public function getFullUrlAttribute()
    {
        return $this->site->url($this->url);
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

    public function children()
    {
        return $this->hasMany(Article::class, 'parent_id')->with('children');
    }

    public function isHome()
    {
        $website = request()->filled('website') ? request('website') : $this->website;

        return $this->id === $website->home_page_id;
    }

    public function seoTitle()
    {
        if(empty($this->seo_title)) {
            return $this->title . ' - ' . request('website')->title;
        } else {
            return $this->seo_title;
        }
    }

    public function processMeta($meta)
    {
        // Delete previous meta.
        $this->meta()->delete();

        // Create the new meta.
        foreach($meta as $field) {
            $this->meta()->create([
                'key' => $field['key'],
                'value' => $field['value'],
            ]);
        }
    }

    public function getMetaField($key)
    {
        if(! $this->relationLoaded('meta')) {
            $this->load('meta');
        }

        return optional($this->meta->where('key', $key)->first())->value;
    }
}
