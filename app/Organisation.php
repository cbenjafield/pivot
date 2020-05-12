<?php

namespace App;

use App\Http\Requests\Organisations\OrganisationRequest;
use App\Traits\HasUrl;
use Illuminate\Database\Eloquent\Model;

class Organisation extends Model
{
    use HasUrl;

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
     * Create a new organisation from the user's request,
     * then redirect them to the edit organisation page.
     * 
     * @param  \App\Http\Requests\Organisations\OrganisationRequest  $request
     * @return \Illuminate\Http\Response
     */
    public static function createFromUserRequest(OrganisationRequest $request)
    {
        $organisation = auth()->user()
                                ->organisations()
                                ->create(static::fillableRequestAttributes($request));
        
        return redirect()->route('organisations.show', $organisation->id);
    }

    /**
     * Update an organisation from the user's request,
     * then redirect them to the back to the edit
     * organisation page.
     * 
     * @param  \App\Http\Requests\Organisations\OrganisationRequest  $request
     */
    public function updateFromUserRequest(OrganisationRequest $request)
    {
        $this->update(static::fillableRequestAttributes($request));

        return redirect()->route('organisations.show', $this->id)
                            ->with('success', 'The organisation has been updated.');
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
