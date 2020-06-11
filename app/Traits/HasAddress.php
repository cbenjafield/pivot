<?php

namespace App\Traits;

trait HasAddress
{
    public function getStringAddressAttribute()
    {
        return implode(', ', array_filter([
            $this->street_address,
            $this->locality,
            $this->city,
            $this->postcode
        ]));
    }

    public function addressSchema()
    {
        return view('schema.address', [
            'website' => $this
        ]);
    }
}