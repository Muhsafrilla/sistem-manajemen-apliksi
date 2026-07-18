<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VenueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $venues = [
            ['name' => 'Jakarta Convention Center', 'address' => 'Jl. Gatot Subroto, Jakarta', 'capacity' => 5000],
            ['name' => 'Indonesia Convention Exhibition (ICE)', 'address' => 'BSD City, Tangerang', 'capacity' => 10000],
            ['name' => 'JIExpo Kemayoran', 'address' => 'Kemayoran, Jakarta Pusat', 'capacity' => 8000],
            ['name' => 'Bali Nusa Dua Convention Center', 'address' => 'Nusa Dua, Bali', 'capacity' => 3000],
            ['name' => 'Sentul International Convention Center', 'address' => 'Sentul, Bogor', 'capacity' => 12000],
        ];

        foreach ($venues as $venue) {
            \App\Models\Venue::firstOrCreate(
                ['name' => $venue['name']],
                ['address' => $venue['address'], 'capacity' => $venue['capacity']]
            );
        }
    }
}
