<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // Role::create(['name' => 'Edara']);
        // Role::create(['name' => 'Lawyer']);
        // Role::create(['name' => 'Customer']);

            // $this->call([CaseTypeSeeder::class,]);
            $this->call([CaseStatus::class,]);

    }
}
