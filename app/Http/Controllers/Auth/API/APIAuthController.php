<?php

namespace App\Http\Controllers\Auth\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegiterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;


class APIAuthController extends Controller
{
    public function register(RegiterRequest $request) : JsonResponse
    {
        $user = User::query()->create([
            'name'=>$request->get('name'),
            'email'=>$request->get('email'),
            'password'=>bcrypt($request->get('password'))
        ]);
        $token = $user->createToken('frontend_news_token')->accessToken;

        return response()->json(['name'=>$user->name,'email'=>$user->email,'token' => $token], 201);
    }

    public function login(LoginRequest $request) :JsonResponse
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password]))
        {
            $user = Auth::user();
            $token = $user->createToken('frontend_news_token')->accessToken;
            return response()->json(['name'=>$user->name,'email'=>$user->email,'token' => $token], 201);
        }
        else
        {
            return response()->json(['error'=>'Unauthorized'], 401);
        }
    }
}
