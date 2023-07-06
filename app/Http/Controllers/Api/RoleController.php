<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;

class RoleController extends Controller
{
    use ApiResponse;

    public function addRole(Request $request){

        $role=Role::create([
            'name'=>$request->name
        ]);

        return $this->SuccessResponse('Role Added');
    }
}
