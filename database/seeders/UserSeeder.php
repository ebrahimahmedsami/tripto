<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::updateOrCreate(['email' => 'admin@gmail.com'],[
            'name'=>'Admin',
            'email' => 'admin@gmail.com',
            'image' => '/assets/images/avatar.png',
            'password' => 123456,
            'type' => 1,
            'role_id' => 1,
        ]);
    }
}
