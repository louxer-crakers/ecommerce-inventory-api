<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        User::firstOrCreate(
            ['email' => 'admin@ecommerce.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('admin123')
            ]
        );
    }
}
