<?php

namespace App\Wolf;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Order extends Model
{
    protected $connection = 'wolf';

    protected $table = 'unapproved_payments';

    protected $guarded = [];

    protected static function booted()
    {
        
    }

    /**
     * Generate an Order ID.
     * 
     * @return string
     */
    public static function makeOrderId()
    {
        $uuid = (string) Str::uuid();
        return "D247P-{$uuid}";
    }

    /**
     * Get the formatted price attribute.
     * 
     * @return string
     */
    public function getPriceAttribute()
    {
        return number_format(($this->amount / 100), 2);
    }

    /**
     * Get the field for route-model binding.
     * 
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'order_id';
    }
}
