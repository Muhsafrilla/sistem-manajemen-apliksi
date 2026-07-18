<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrganizerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $organizerUser = \App\Models\User::where('role', 'Organizer')->first();
        if ($organizerUser) {
            \App\Models\Organizer::firstOrCreate(
                ['user_id' => $organizerUser->id],
                [
                    'company_name' => 'PT Jaya Abadi Event',
                    'contact_email' => 'contact@jayaabadievent.com',
                    'phone' => '081234567890'
                ]
            );
        }
    }
}
