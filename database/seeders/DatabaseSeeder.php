<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
                        // Create Admin User
                        User::firstOrCreate(
                            ['email' => 'admin@surasa.id'],
                            [
                                'name' => 'Administrator',
                                'password' => Hash::make('password'),
                                'role' => 'admin',
                            ]
                        );
                
                        // Create Test User
                        User::firstOrCreate(
                            ['email' => 'user@surasa.id'],
                            [
                                'name' => 'Test User',
                                'password' => Hash::make('password'),
                                'role' => 'user',
                            ]
                        );        
                // Seed Categories and Kuliners
                $this->call([
                    CategorySeeder::class,
                    KulinerSeeder::class,
                    RecipeSeeder::class,
                ]);
    }
}
