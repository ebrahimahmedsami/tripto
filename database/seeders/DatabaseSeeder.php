<?php

namespace Database\Seeders;

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

        $this->call([
            // RoleSeeder::class,
            // UserSeeder::class,
            // GovernmentSeeder::class,
            // CitiesSeeder::class
        ]);
//        Organization::factory(10)->create();
//        Branch::factory(10)->create();
//        Department::factory(10)->create();
//        Service::factory(10)->create();
//        Member::factory(10)->create();
//        MemberService::factory(10)->create();

    }
}
