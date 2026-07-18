<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Speaker extends Model
{
    protected $fillable = ['name', 'company', 'contact', 'bio', 'photo_url'];

    public function events()
    {
        return $this->belongsToMany(Event::class);
    }
}
