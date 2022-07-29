<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        Plan::create([
            'name' => 'Basic',
            'price' => '100'
        ]);
        Plan::create([
            'name' => 'Advanced',
            'price' => '400'
        ]);
        Plan::create([
            'name' => 'Premium',
            'price' => '600'
        ]);
    }
}
