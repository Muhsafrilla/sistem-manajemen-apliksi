<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Organizer extends Model
{
    protected $fillable = ['user_id', 'company_name', 'contact_email', 'phone'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
