<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin; // Ensure this matches your Admin model's namespace

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::create([
            'name' => 'Admin Name',  // Replace with your desired admin name
            'username' => 'admin1',  // Replace with your desired admin username
            'password' => bcrypt('password'),  // Replace 'password123' with a secure password
        ]);
    }
}
