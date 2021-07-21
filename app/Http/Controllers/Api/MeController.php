<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;

class MeController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {
        // return new UserResource(Auth::user());
        if(auth()->check()){
            $user = auth()->user();
            return new UserResource($user);
        }
        return response()->json(null, 401);
    }
}
