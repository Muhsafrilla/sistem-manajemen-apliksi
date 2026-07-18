<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RegistrationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $events = \App\Models\Event::where('status', 'Published')->get();
        if ($events->count() == 0) return;

        $user = \App\Models\User::where('role', 'Attendee')->first();
        
        foreach ($events as $event) {
            $ticket = $event->tickets()->where('is_active', true)->where('quota', '>', 0)->first();
            if (!$ticket) continue;

            \App\Models\Registration::firstOrCreate([
                'event_id'  => $event->id,
                'email'     => $user ? $user->email : 'guest@example.com',
            ], [
                'user_id'       => $user ? $user->id : null,
                'name'          => $user ? $user->name : 'Guest User',
                'phone'         => '08123456789',
                'ticket_id'     => $ticket->id,
                'status'        => 'Confirmed',
                'registered_at' => now(),
            ]);

            // Reduce quota
            $ticket->decrement('quota', 1);
        }
    }
}
