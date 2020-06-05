<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Media extends Model
{
    protected $table = 'media';

    protected $guarded = [];

    protected $appends = [
        'url'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function url()
    {
        return Storage::disk('media')->url($this->name);
    }

    public function getUrlAttribute()
    {
        return $this->url();
    }

    public function site()
    {
        return $this->belongsTo(Site::class);
    }

    public function getDisk()
    {
        return Storage::disk($this->disk);
    }

    public function isImage()
    {
        return in_array($this->type, [
            'image/jpeg',
            'image/png',
            'image/gif',
            'image/webp',
            'image/svg'
        ]);
    }
}
