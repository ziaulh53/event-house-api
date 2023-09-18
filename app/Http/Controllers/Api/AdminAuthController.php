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
    public function adminSignup(AdminSignup $request)
    {
        $data = $request->validated();
        /** @var  \App\Models\Admin $admin */

        Admin::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'role' => 'super_admin',
            'password' => bcrypt($data['password']),
        ]);
        return response(['success' => true]);
    }
    public function adminLogin(AdminLogin $request)
    {
        $credential = $request->validated();
        if (!Auth::guard('admin')->attempt($credential)) {
            return response([
                'message' => 'Email or Password is incorrect',
                'success' => false
            ], 422);
        }
        /** @var Admin $user */
        $user  = Auth::guard('admin')->user();
        $token = $user->createToken('main')->plainTextToken;
        $success = true;
        return response(compact('user', 'token', 'success'));
    }

    public function adminLogout(AdminLogout $request)
    {
        /** @var Admin $user */
        $user = $request->user();
        $user->currentAccessToken()->delete;
        return response(['success'=>true]);
    }
}
