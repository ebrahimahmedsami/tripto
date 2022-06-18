<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Organization;
use App\Models\Branch;
use App\Models\Department;
use App\Models\Service;
use App\Models\Member;
use App\Models\MemberService;

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
            RoleSeeder::class,
            UserSeeder::class,
        ]);
//        Organization::factory(10)->create();
//        Branch::factory(10)->create();
//        Department::factory(10)->create();
//        Service::factory(10)->create();
//        Member::factory(10)->create();
//        MemberService::factory(10)->create();

    }
}
