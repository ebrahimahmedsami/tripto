<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        Role::truncate();
        Schema::enableForeignKeyConstraints();
        $tblPermissions = permissions();
        $permissions=[];
        foreach ($tblPermissions as $key=>$tblPermission){
            $permissions[$key] =  [
                "name"=> $tblPermission,
                "read"=> true,
                "write"=> true,
                "delete"=> true,
                "update"=> true,
            ];
        }
        Role::create([
            'roleName'=>'admin',
            'permissions'=>json_encode($permissions)
        ]);
    }
}
