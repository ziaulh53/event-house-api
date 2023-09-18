<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminLogin;
use App\Http\Requests\AdminLogout;
use App\Http\Requests\AdminSignup;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    public function adminSignup(AdminSignup $request){
        $data = $request->validated();
        /** @var Admin $admin */
        Admin::create([
            'name'=> $data['name'],
            'email'=> $data['email'],
            'role'=> $data['role'],
            'password'=> bcrypt($data['password']),
        ]);
        return response(['success'=>true, 'msg'=>'New admin added']);
    }
    public function adminLogin(AdminLogin $request){
        $credential = $request->validated();
        if (!Auth::attempt($credential)) {
            return response([
                'message' => 'Email or Password is incorrect',
                'success' => false
            ], 422);
        }
        /** @var Admin $admin */
        $admin  = Auth::user();
        $token = $admin->createToken('main')->plainTextToken;
        $success = true;
        return response(compact('admin', 'token', 'success'));
    }

    public function adminLogout(AdminLogout $request){
         /** @var Admin $admin */
         $admin = $request->user();
         $admin->currentAccessToken()->delete;
         return response(['success'=>true]);
    }
}
