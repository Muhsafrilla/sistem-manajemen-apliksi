<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EventCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Seminar', 'description' => 'Acara edukasi dan presentasi oleh ahli.'],
            ['name' => 'Workshop', 'description' => 'Pelatihan interaktif dan praktik langsung.'],
            ['name' => 'Konser', 'description' => 'Pertunjukan musik dan hiburan.'],
            ['name' => 'Konferensi', 'description' => 'Pertemuan formal untuk diskusi dan pertukaran informasi.'],
            ['name' => 'Exhibition', 'description' => 'Pameran produk, seni, atau layanan.'],
        ];

        foreach ($categories as $category) {
            \App\Models\EventCategory::firstOrCreate(
                ['name' => $category['name']],
                ['description' => $category['description']]
            );
        }
    }
}
