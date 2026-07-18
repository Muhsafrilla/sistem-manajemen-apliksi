<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    protected $fillable = [
        'event_id', 'user_id', 'name', 'email', 'phone', 
        'ticket_id', 'status', 'registered_at', 'is_attended'
    ];

    protected $casts = [
        'registered_at' => 'datetime',
        'is_attended' => 'boolean',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
}
