<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;

class RoleController extends Controller
{
    public function getAdminPage(){
        $users = User::latest()->paginate(20);
        $role = Role::All();
        $roles=array();
        foreach ($role as $data) {
            $roles[$data->id]= $data->name;
        }
        return view('admin.pages.role')->withUsers($users)->withRoles($roles);
    }

    public function postAssignRole(Request $request){
        //dd($request->roles);

        $user = User::where('email',$request['email'])->first();
        //$user->roles()->detach();
        $user->roles()->sync($request->roles);
        
        /*if($request['role_store']){
            $user->roles()->attach(Role::where('name','Store')->first());
        }
        
        if($request['role_lab']){
            $user->roles()->attach(Role::where('name','Lab')->first());
        }

        if($request['role_hr']){
            $user->roles()->attach(Role::where('name','HR')->first());
        }

        if($request['role_admin']){
            $user->roles()->attach(Role::where('name','Admin')->first());
        }*/
        return redirect()->back();
    }

}
