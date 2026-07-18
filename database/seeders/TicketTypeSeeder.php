<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TicketTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            ['name' => 'Regular',    'description' => 'Tiket masuk standar tanpa fasilitas tambahan.'],
            ['name' => 'VIP',        'description' => 'Tiket dengan akses ke area VIP dan kursi prioritas.'],
            ['name' => 'VVIP',       'description' => 'Tiket eksklusif dengan semua fasilitas premium termasuk meet & greet.'],
            ['name' => 'Early Bird', 'description' => 'Tiket harga spesial bagi pembelian lebih awal (kuota terbatas).'],
            ['name' => 'Student',    'description' => 'Tiket diskon khusus pelajar/mahasiswa (dengan kartu pelajar).'],
        ];

        foreach ($types as $type) {
            \App\Models\TicketType::firstOrCreate(['name' => $type['name']], ['description' => $type['description']]);
        }
    }
}
