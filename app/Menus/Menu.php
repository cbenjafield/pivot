<?php

namespace App\Menus;

use App\Site;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $guarded = [];

    public function site()
    {
        return $this->belongsTo(Site::class);
    }

    public function items()
    {
        return $this->hasMany(MenuItem::class);
    }

    public function attachItems($items = [])
    {
        foreach($items as $item) {
            $this->items()->create([
                'title' => $item['title'],
                'destination' => $item['destination'],
                'sequence' => $item['sequence'],
            ]);
        }
    }
}
