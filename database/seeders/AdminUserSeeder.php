<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'Romanvov@site.com'],
            [
                'name' => 'Rinac Romanvov',
                'password' => 'Romanvov@Rinac', // Cast to hashed in model
                'role' => 'admin',
            ]
        );
    }
}
