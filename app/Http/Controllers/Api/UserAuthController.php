<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserLogin;
use App\Http\Requests\UserLogout;
use App\Http\Requests\UserSignup;
use App\Http\Requests\UserUpdate;
use App\Models\User;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;

class UserAuthController extends Controller
{
    public function userSignup(UserSignup $request)
    {
        $data = $request->validated();
        /** @var User $user */
        User::create($data);
        return response(['success' => true, 'msg' => 'Registration Successfully']);
    }
    public function userLogin(UserLogin $request)
    {
        $credential = $request->validated();
        if (!Auth::attempt($credential)) {
            return response([
                'msg' => 'Email or Password is incorrect',
                'success' => false
            ], 200);
        }
        /** @var User $user */
        $user  = Auth::user();
        $token = $user->createToken('main')->plainTextToken;
        $success = true;
        return response(compact('user', 'token', 'success'));
    }

    public function userUpdate(UserUpdate $request)
    {
        $user = auth()->user();
        $data = $request->validated();
         /** @var User $user */
        $user->update($data);
        return response(['success'=>true, 'msg'=>'Profile info updated']);
    }

    public function userLogout(UserLogout $request)
    {
        /** @var User $user */
        $user = $request->user();
        $user->currentAccessToken()->delete;
        return response(['success' => true]);
    }

    public function userResetPasswordRequest(Request $request)
    {
        /** @var User $user */
        $user = User::where('email', $request['email'])->first();
        if (!$user) {
            return response(['success' => false, 'msg' => 'User not found'], 404);
        }
        Password::sendResetLink($user->email);
    }
}
