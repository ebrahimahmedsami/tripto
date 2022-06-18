<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
        Gate::define('admin',function (User $user,$cr_role){


            if($user->status){
                if(!$user->group()->exists())
                    return false;
                foreach (json_decode($user->group->permissions) as $permission){
                    if(($permission->read ? 'read ' : '') . $permission->name == $cr_role){
                        return true;
                    }elseif (($permission->write ? 'write ' : '') . $permission->name == $cr_role){
                        return true;
                    }elseif (($permission->delete ? 'delete ' : '') . $permission->name == $cr_role){
                        return true;
                    }elseif (($permission->update ? 'update ' : '') . $permission->name == $cr_role){
                        return true;
                    }else{
                       continue;
                    }
                }
            }
        });
    }
}
