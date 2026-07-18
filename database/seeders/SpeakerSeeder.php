<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SpeakerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $speakers = [
            ['name' => 'Dr. Budi Santoso', 'company' => 'Tech Indo', 'contact' => 'budi@techindo.com', 'bio' => 'Pakar AI di Indonesia.'],
            ['name' => 'Siti Aminah, M.Kom', 'company' => 'UI/UX Agency', 'contact' => 'siti@uiux.com', 'bio' => 'Desainer UI/UX dengan 10 tahun pengalaman.'],
            ['name' => 'Andi Wijaya', 'company' => 'Startup Hub', 'contact' => 'andi@startup.id', 'bio' => 'Investor dan mentor startup.'],
        ];

        $events = \App\Models\Event::all();

        foreach ($speakers as $data) {
            $speaker = \App\Models\Speaker::firstOrCreate(['name' => $data['name']], $data);
            if ($events->count() > 0) {
                // Attach to 1-2 random events
                $speaker->events()->sync($events->random(rand(1, 2))->pluck('id')->toArray());
            }
        }
    }
}
