<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\PreferenceRequest;
use App\Models\UserPreference;
use Illuminate\Support\Facades\Auth;


class UsersController extends Controller
{
    public function savePreference(PreferenceRequest $request)
    {
        $preference = UserPreference::query()->updateOrCreate(
            ['user_id' => Auth::user()->id],
            ['preferences'=> ['categories'=>$request->get('categories') ?? [],'sources'=>$request->get('sources') ?? [],'perPage'=>$request->get('perPage') ?? 100]]
        );
        return response()->json($preference);
    }

    public function logout()
    {
        Auth()->user()->token()->revoke();
        return response()->json(['message' => 'Successfully logged out']);
    }
}
