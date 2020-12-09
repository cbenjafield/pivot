<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Http\Requests\Organisations\OrganisationRequest;
use App\Traits\CreatesFromRequest;
use App\Traits\HasAddress;
use App\Traits\HasUrl;

class Organisation extends Model
{
    use HasUrl, CreatesFromRequest, HasAddress;

    protected $guarded = [];

    protected static function booted()
    {
        static::created(function ($model) {
            $model->refreshViewCache();
        });

        static::updated(function ($model) {
            $model->refreshViewCache();
        });
    }

    public function refreshViewCache()
    {
        $organisations = Cache::rememberForever('organisations', function () {
            return Organisation::orderBy('name', 'asc')->get();
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the fillable request attributes from the request.
     * 
     * @param  \App\Http\Requests\Organisations\OrganisationRequest  $request
     * @return array
     */
    public static function fillableRequestAttributes(OrganisationRequest $request, array $params = [])
    {
        return array_merge($request->only([
            'name',
            'description',
            'street_address',
            'locality',
            'city',
            'postcode',
            'paypal_client_id',
            'paypal_client_secret',
        ]), $params);
    }

    /**
     * Get the first character of the organisation name.
     * 
     * @return string
     */
    public function getInitialAttribute()
    {
        return strtoupper($this->name[0]);
    }
}
