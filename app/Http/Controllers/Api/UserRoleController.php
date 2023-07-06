<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
class UserRoleController extends Controller
{
    public function addUserRole(Request $request,$uid,$rid){
        $user=User::findOrFail($uid);
        $role=Rule::findOrFail($rid);
        $user->roles()->attach($role);
        return $this->SuccessResponse('Added role successfuly for this user',200);
    }

    public function updateUserRole(){

    }

    public function deleteUserRole($uid,$rid)
    {
        $user=User::findOrFail($uid);
        $role=Role::findOrFail($rid);
        if($user && $role){
            $user->roles()->detach($role);
            return $this->SuccessResponse('Deleted Role from this user',200);
        }
        else{
            return $this->errorResponse('An error occured',403);
        }


    }
}
