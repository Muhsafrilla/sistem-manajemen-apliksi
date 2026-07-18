<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $organizer = \App\Models\Organizer::first();
        if (!$organizer) return;

        $categories = \App\Models\EventCategory::all()->keyBy('name');
        $venues     = \App\Models\Venue::all();

        $events = [
            [
                'title'       => 'Seminar Nasional Teknologi Informasi 2025',
                'description' => 'Seminar tahunan membahas tren terkini di dunia teknologi informasi.',
                'start_date'  => '2025-09-10 08:00:00',
                'end_date'    => '2025-09-10 17:00:00',
                'status'      => 'Published',
                'category'    => 'Seminar',
            ],
            [
                'title'       => 'Workshop UI/UX Design Fundamentals',
                'description' => 'Pelatihan intensif desain antarmuka dan pengalaman pengguna.',
                'start_date'  => '2025-10-05 09:00:00',
                'end_date'    => '2025-10-06 16:00:00',
                'status'      => 'Published',
                'category'    => 'Workshop',
            ],
            [
                'title'       => 'Konferensi Bisnis & Startup Indonesia 2025',
                'description' => 'Forum pertemuan para pelaku bisnis dan startup terkemuka di Indonesia.',
                'start_date'  => '2025-11-15 08:00:00',
                'end_date'    => '2025-11-16 18:00:00',
                'status'      => 'Published',
                'category'    => 'Konferensi',
            ],
            [
                'title'       => 'Konser Musik Akhir Tahun 2025',
                'description' => 'Malam perayaan akhir tahun dengan penampilan musisi papan atas.',
                'start_date'  => '2025-12-31 19:00:00',
                'end_date'    => '2026-01-01 01:00:00',
                'status'      => 'Published',
                'category'    => 'Konser',
            ],
            [
                'title'       => 'Pameran Produk Digital Indonesia',
                'description' => 'Pameran produk dan inovasi teknologi digital dari seluruh Indonesia.',
                'start_date'  => '2026-02-20 09:00:00',
                'end_date'    => '2026-02-22 18:00:00',
                'status'      => 'Draft',
                'category'    => 'Exhibition',
            ],
            [
                'title'       => 'Workshop Data Science & AI',
                'description' => 'Pelatihan hands-on tentang kecerdasan buatan dan analisis data.',
                'start_date'  => '2026-03-08 09:00:00',
                'end_date'    => '2026-03-09 17:00:00',
                'status'      => 'Draft',
                'category'    => 'Workshop',
            ],
            [
                'title'       => 'Seminar Kewirausahaan Pemuda',
                'description' => 'Menginspirasi generasi muda untuk terjun ke dunia wirausaha.',
                'start_date'  => '2026-04-12 08:00:00',
                'end_date'    => '2026-04-12 15:00:00',
                'status'      => 'Draft',
                'category'    => 'Seminar',
            ],
            [
                'title'       => 'Konferensi Kesehatan Digital Nasional',
                'description' => 'Pertemuan para ahli membahas digitalisasi layanan kesehatan di Indonesia.',
                'start_date'  => '2026-05-20 08:00:00',
                'end_date'    => '2026-05-21 17:00:00',
                'status'      => 'Draft',
                'category'    => 'Konferensi',
            ],
            [
                'title'       => 'Festival Musik Indie Jakarta',
                'description' => 'Ajang apresiasi musik indie lokal dari berbagai genre.',
                'start_date'  => '2026-06-07 14:00:00',
                'end_date'    => '2026-06-07 23:00:00',
                'status'      => 'Draft',
                'category'    => 'Konser',
            ],
            [
                'title'       => 'Pameran Seni & Budaya Nusantara',
                'description' => 'Pameran karya seni dan budaya dari 34 provinsi Indonesia.',
                'start_date'  => '2026-07-17 09:00:00',
                'end_date'    => '2026-07-20 18:00:00',
                'status'      => 'Draft',
                'category'    => 'Exhibition',
            ],
        ];

        foreach ($events as $i => $data) {
            $category = $categories->get($data['category']) ?? \App\Models\EventCategory::first();
            $venue    = $venues->get($i % $venues->count());
            if (!$category || !$venue) continue;

            \App\Models\Event::firstOrCreate(
                ['title' => $data['title']],
                [
                    'organizer_id' => $organizer->id,
                    'category_id'  => $category->id,
                    'venue_id'     => $venue->id,
                    'description'  => $data['description'],
                    'start_date'   => $data['start_date'],
                    'end_date'     => $data['end_date'],
                    'status'       => $data['status'],
                ]
            );
        }
    }
}
