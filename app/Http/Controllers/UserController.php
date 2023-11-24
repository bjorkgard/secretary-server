<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function upsert(UserRegisterRequest $request)
    {
        $user = User::updateOrCreate(
            ['email' => $request->email],
            [
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt(Str::random(24))
            ]
        );

        $token = $user->createToken($request->device_platform, ['read', 'create', 'update', 'delete'])->plainTextToken;

        return response()->json([
            'token' => explode('|', $token, 2)[1],
        ], 201);
    }
}
