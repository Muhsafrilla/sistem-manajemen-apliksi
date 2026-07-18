<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FeedbackFormSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $events = \App\Models\Event::where('status', 'Published')->get();
        $user = \App\Models\User::where('role', 'Attendee')->first();

        if (!$user || $events->count() == 0) return;

        foreach ($events->take(5) as $event) {
            \App\Models\FeedbackForm::create([
                'event_id' => $event->id,
                'user_id' => $user->id,
                'rating' => rand(3, 5),
                'comments' => 'Acaranya sangat bermanfaat dan inspiratif!',
            ]);
        }
    }
}
