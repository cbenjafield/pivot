<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Http\Requests\Organisations\OrganisationRequest;
use App\Traits\CreatesFromRequest;
use App\Traits\HasUrl;

class Organisation extends Model
{
    use HasUrl, CreatesFromRequest;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getStringAddressAttribute()
    {
        return implode(', ', array_filter([
            $this->street_address,
            $this->locality,
            $this->city,
            $this->postcode
        ]));
    }

    /**
     * @todo Add address schema method
     * @todo Add phone number methods
     */

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
