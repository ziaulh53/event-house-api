<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class UserPasswordResetController extends Controller
{
    public function forgotPassword(Request $request)
    {
        
        $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['error' => 'User not found.'], 404);
        }

        Password::broker('users')->sendResetLink($request->only('email'));

        return response(['success'=>true, 'msg'=>'Password reset link sent successfully.'], 201);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'password' => 'required',
        ]);

        $user = Password::broker('users')->reset($request->only('email', 'password', 'token'), function (User $user, $password) {
            $user->password = Hash::make($password);
            $user->save();
        });

        if (!$user) {
            return response()->json(['error' => 'Invalid token.'], 401);
        }

        return response(['success'=>true, 'msg'=>'Password reset successfully.']);
    }
}
