<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminLogin;
use App\Http\Requests\AdminSignup;
use App\Models\Admin;
use Illuminate\Http\Request;

class AdminAuthController extends Controller
{
    public function adminSignup(AdminSignup $request){
        $data = $request->validated();
        /** @var Admin $user */
        Admin::create([
            'name'=> $data['name'],
            'email'=> $data['email'],
            'role'=> $data['role'],
            'password'=> bcrypt($data['password']),
        ]);
        return response(['success'=>true, 'msg'=>'New admin added']);
    }
    public function adminLogin(AdminLogin $request){
       
    }

    public function adminLogout(AdminLogin $request){

    }
}
