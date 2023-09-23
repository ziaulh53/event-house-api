<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class AdminPasswordResetController extends Controller
{
    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $admin = Admin::where('email', $request->email)->first();

        if (!$admin) {
            return response()->json(['error' => 'User not found.'], 404);
        }

        Password::broker('admins')->sendResetLink($request->only('email'));

        return response(['success'=>true, 'msg'=>'Password reset link sent successfully.'], 201);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'password' => 'required',
        ]);

        $admin =  Password::broker('admins')->reset($request->only('email', 'password', 'token'), function (Admin $admin, $password) {
            $admin->password = Hash::make($password);
            $admin->save();
        });

        if (!$admin) {
            return response()->json(['error' => 'Invalid token.'], 401);
        }

        return response()->json(['message' => 'Password reset successfully.']);
    }
}
