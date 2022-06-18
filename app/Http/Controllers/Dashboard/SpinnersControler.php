<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Traits\ResponseTrait;
use App\Models\Branch;
use App\Models\Department;
use App\Models\Organization;
use App\Models\Role;
use App\Models\service;
use Illuminate\Http\Request;

class SpinnersControler extends Controller
{

    use ResponseTrait;

    public function organizations(){
        $organizations = Organization::select('id','name')->where('status',1)->get();
        return $this->returnData('organizations',$organizations);
    }

    public function branches(){
        $branches = Branch::select('id','name')->get();
        return $this->returnData('branches',$branches);
    }

    public function departments(){
        $departments = Department::select('id','name')->where('status',1)->get();
        return $this->returnData('departments',$departments);
    }

    public function services(){
        $services = service::select('id','name')->where('status',1)->get();
        return $this->returnData('services',$services);
    }

    public function permissions(){
        return $this->returnData('permissions',permissions());
    }
    public function roles(){
        $roles=Role::select([ 'roleName as name' , 'id'])->get();
        return $this->returnData('roles',$roles);
    }

    public function webhookRecieve()
    {
        
    }
}
