<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'organizer_id', 'category_id', 'venue_id',
        'title', 'description', 'start_date', 'end_date', 'poster', 'status',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    public function organizer()
    {
        return $this->belongsTo(Organizer::class);
    }

    public function category()
    {
        return $this->belongsTo(EventCategory::class, 'category_id');
    }

    public function venue()
    {
        return $this->belongsTo(Venue::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function speakers()
    {
        return $this->belongsToMany(Speaker::class);
    }

    public function sponsors()
    {
        return $this->belongsToMany(Sponsor::class);
    }
}
