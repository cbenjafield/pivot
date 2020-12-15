<?php

namespace App;

use App\Http\Requests\Sites\CreateRequest;
use App\Menus\Menu;
use App\Services\HealthCheck;
use App\Traits\CreatesFromRequest;
use App\Traits\HasUrl;
use App\Traits\UploadsMedia;
use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    use CreatesFromRequest, UploadsMedia;

    protected $guarded = [];

    protected $with = [
        'organisation',
    ];

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
            'paypal_client_id',
            'paypal_client_secret',
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
        if(!is_null($this->home_page_id)) return false;
        
        $this->update([
            'home_page_id' => $id,
        ]);
    }

    /**
     * If the site has a homepage, return true.
     * otherwise, return false, so the site
     * can display an index of blog posts.
     * 
     * @return bool
     */
    public function hasHomePage()
    {
        return !! $this->home_page_id;
    } 

    /**
     * Return the site's homepage.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function homepage()
    {
        return $this->belongsTo(Article::class, 'home_page_id');
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

    /**
     * Check the website's health.
     * 
     * @return bool
     */
    public function checkHealth()
    {
        $healthCheck = (new HealthCheck($this->domain()))->check();

        $this->update([
            'passed_health_check' => $healthCheck->status == 200 ? 1 : 0
        ]);
    }

    public function url($path = null)
    {
        return $this->domain() . (!empty($path) ? '/' . $path : '');
    }

    /**
     * Return the website's theme path.
     * 
     * @return string
     */
    public function themePath($file)
    {
        return ($this->theme ?? 'default') . ".{$file}";
    }

    /**
     * Determine if the website has a logo uploaded.
     * 
     * @return bool
     */
    public function hasLogo()
    {
        return !is_null($this->logo_path);
    }

    /**
     * Define the site's relationship to menus
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function menus()
    {
        return $this->hasMany(Menu::class);
    }

    /**
     * Define the site's relationship to media items.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function media()
    {
        return $this->hasMany(Media::class);
    }

    /**
     * Define the site's relationship to contact forms.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function contactForms()
    {
        return $this->hasMany(ContactForm::class);
    }

    /**
     * Define the relationship to products.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Paypal Credentials
     * 
     * Return the PayPal API keys for the site. If no details are supplied,
     * the PayPal tokens supplied for the organisation the website belongs
     * to will be used. Otherwise, an array with null values will return.
     * 
     * @return array
     */
    public function paypalCredentials()
    {
        if(! empty($this->paypal_client_id) && ! empty($this->paypal_client_secret)) {
            return [
                'client_id' => $this->paypal_client_id,
                'secret' => $this->paypal_client_secret,
            ];
        }

        return [
            'client_id' => $this->organisation->paypal_client_id ?? null,
            'secret' => $this->organisation->paypal_client_secret ?? null,
        ];
    }
}