<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{

    public function run(): void
    {
        try {
            User::factory()
                ->count(10)
                ->state([
                    'first_name' => 'John',
                    'last_name' => 'Doe',
                    'username' => 'johndoe',
                    'last_active' => now(),
                    'type' => 'seeker',
                    'image' => null,
                    'identity_card' => null,
                    'phone' => Str::random(10),
                    'password' => bcrypt('password'),
                    'location_id' => 1,
                    'status' => 'active',
                    'is_featured' => 0,
                    'job_id' => 1,
                ])
                ->create();
        } catch (\Exception $e) {
            report($e);
            throw $e;
        }
    }

}
