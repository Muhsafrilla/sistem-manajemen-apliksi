<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sponsor extends Model
{
    protected $fillable = ['name', 'tier', 'contact', 'logo_url'];

    public function events()
    {
        return $this->belongsToMany(Event::class);
    }
}
