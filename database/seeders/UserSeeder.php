<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Tamus Tahir (Superadmin)',
                'email' => 'tamus@gmail.com',
                'role' => 'Superadmin',
            ],
            [
                'name' => 'John Organizer',
                'email' => 'organizer@gmail.com',
                'role' => 'Organizer',
            ],
            [
                'name' => 'Budi Attendee',
                'email' => 'attendee@gmail.com',
                'role' => 'Attendee',
            ],
            [
                'name' => 'Dr. Speaker',
                'email' => 'speaker@gmail.com',
                'role' => 'Speaker',
            ],
            [
                'name' => 'PT Sponsor',
                'email' => 'sponsor@gmail.com',
                'role' => 'Sponsor',
            ],
        ];

        foreach ($users as $user) {
            if (User::where('email', $user['email'])->exists()) {
                continue;
            }

            User::factory()->create([
                'name' => $user['name'],
                'email' => $user['email'],
                'role' => $user['role'],
            ]);
        }
    }
}
