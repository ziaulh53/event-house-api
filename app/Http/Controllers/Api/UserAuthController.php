<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserLogin;
use App\Http\Requests\UserLogout;
use App\Http\Requests\UserSignup;
use App\Models\User;

class UserAuthController extends Controller
{
    public function userSignup(UserSignup $request){
        $data = $request->validated();
        /** @var User $user */
        User::create([
            'name'=> $data['name'],
            'email'=> $data['email'],
            'role'=> $data['role'],
            'password'=> bcrypt($data['password']),
        ]);
        return response(['success'=>true, 'msg'=>'Registration Successfully']);
    }
    public function userLogin(UserLogin $request){
           
    }

    public function userLogout(UserLogout $request){

    }
}
