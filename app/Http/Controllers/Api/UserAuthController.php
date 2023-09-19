<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserLogin;
use App\Http\Requests\UserLogout;
use App\Http\Requests\UserSignup;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserAuthController extends Controller
{
    public function userSignup(UserSignup $request){
        $data = $request->validated();
        /** @var User $user */
        User::create([
            'name'=> $data['name'],
            'email'=> $data['email'],
            'phone'=> $data['phone'],
            'role'=> $data['role'],
            'password'=> bcrypt($data['password']),
        ]);
        return response(['success'=>true, 'msg'=>'Registration Successfully']);
    }
    public function userLogin(UserLogin $request){
        $credential = $request->validated();
        if (!Auth::attempt($credential)) {
            return response([
                'message' => 'Email or Password is incorrect',
                'success' => false
            ], 422);
        }
         /** @var User $user */
         $user  = Auth::user();
         $token = $user->createToken('main')->plainTextToken;
         $success = true;
         return response(compact('user', 'token', 'success'));
    }

    public function userLogout(UserLogout $request){
         /** @var User $user */
         $user = $request->user();
         $user->currentAccessToken()->delete;
         return response(['success'=>true]);
    }
}
