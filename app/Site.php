<?php

namespace App;

use App\Http\Requests\Sites\CreateRequest;
use App\Traits\CreatesFromRequest;
use App\Traits\HasUrl;
use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    use CreatesFromRequest;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function organisation()
    {
        return $this->belongsTo(Organisation::class);
    }

    public function domain()
    {
        return "{$this->scheme()}://{$this->www()}{$this->tld}";
    }

    public function scheme()
    {
        return 'http' . ($this->uses_https ? 's' : '');
    }

    public function www()
    {
        return $this->uses_www ? 'www.' : '';
    }

    /**
     * Get the fillable request attributes from the request.
     * 
     * @param  \App\Http\Requests\Sites\CreateRequest|\App\Http\Requests\Sites\UpdateRequest  $request
     * @return array
     */
    public static function fillableRequestAttributes($request)
    {
        return array_merge($request->only([
            'title',
            'description',
            'street_address',
            'locality',
            'city',
            'postcode',
            'tld',
            'organisation_id',
        ]), [
            'uses_https' => $request->filled('uses_https') ? 1 : 0,
            'uses_www'   => $request->filled('uses_www')   ? 1 : 0,
        ]);
    }

    /**
     * Define the sites relationship to articles.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function articles()
    {
        return $this->hasMany(Article::class, 'site_id');
    }

    /**
     * If the site does not have a home page ID specified,
     * set to the one supplied. This prevents a site
     * having no front page when it's live.
     */
    public function updateHomeIfNotExists(int $id)
    {
        $this->update([
            'home_page_id' => $id,
        ]);
    }

    /**
     * Define the relationship to articles with
     * their type set to a "page". This makes
     * it much easier to query pages only.
     */
    public function pages()
    {
        return $this->articles()->whereIn('type', ['page']);
    }
}
