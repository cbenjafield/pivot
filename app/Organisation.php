<?php

namespace App;

use App\Http\Requests\Organisations\CreateRequest;
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
     * Create a new organisation from the user's request,
     * then redirect them to the edit organisation page.
     * 
     * @param  \App\Http\Requests\Organisations\CreateRequest $request
     * @return \Illuminate\Http\Response
     */
    public static function createFromUserRequest(CreateRequest $request)
    {
        $organisation = auth()->user()
                                ->organisations()
                                ->create($request->only([
                                    'name',
                                    'description',
                                    'street_address',
                                    'locality',
                                    'city',
                                    'postcode',
                                ]));
        
        return redirect()->route('organisations.show', [$organisation->id]);
    }
}
