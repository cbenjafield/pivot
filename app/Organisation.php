<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Organisation extends Model
{
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
}
