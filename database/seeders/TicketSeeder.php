<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $events = \App\Models\Event::all();
        $types  = \App\Models\TicketType::all()->keyBy('name');

        $templates = [
            ['type' => 'Regular',    'price' => 50000,  'quota' => 200, 'benefit' => 'Akses acara, snack, sertifikat.'],
            ['type' => 'VIP',        'price' => 150000, 'quota' => 50,  'benefit' => 'Akses VIP area, makan siang, goodie bag, sertifikat.'],
            ['type' => 'Early Bird', 'price' => 35000,  'quota' => 30,  'benefit' => 'Harga spesial early bird, akses seperti Regular.'],
        ];

        foreach ($events as $event) {
            foreach ($templates as $tmpl) {
                $type = $types->get($tmpl['type']);
                if (!$type) continue;

                \App\Models\Ticket::firstOrCreate(
                    ['event_id' => $event->id, 'ticket_type_id' => $type->id],
                    [
                        'price'     => $tmpl['price'],
                        'quota'     => $tmpl['quota'],
                        'benefit'   => $tmpl['benefit'],
                        'is_active' => true,
                    ]
                );
            }
        }
    }
}
