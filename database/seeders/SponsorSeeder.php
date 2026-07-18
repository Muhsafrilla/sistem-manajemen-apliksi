<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SponsorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sponsors = [
            ['name' => 'Bank Mandiri', 'tier' => 'Platinum', 'contact' => 'sponsor@bankmandiri.co.id'],
            ['name' => 'Telkomsel', 'tier' => 'Gold', 'contact' => 'partnership@telkomsel.com'],
            ['name' => 'Gojek', 'tier' => 'Silver', 'contact' => 'event@gojek.com'],
            ['name' => 'Indofood', 'tier' => 'Bronze', 'contact' => 'promo@indofood.com'],
        ];

        $events = \App\Models\Event::all();

        foreach ($sponsors as $data) {
            $sponsor = \App\Models\Sponsor::firstOrCreate(['name' => $data['name']], $data);
            if ($events->count() > 0) {
                // Attach to 1-3 random events
                $sponsor->events()->sync($events->random(rand(1, 3))->pluck('id')->toArray());
            }
        }
    }
}
