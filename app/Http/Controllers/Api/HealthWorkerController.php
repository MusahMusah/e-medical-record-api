<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Support\Str;
use App\Models\HealthWorker;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\HealthWorkerRequest;
use App\Http\Resources\HealthWorkerResource;

class HealthWorkerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(HealthWorkerRequest $request)
    {
        // Register A Health Worker
        // Create health worker in Users table to enable login access
        $user = User::create([
            'name'          => $request->name,
            'email'         => $request->email,
            'password'      => Hash::make($request->password),
            'email_verified_at' => now(),
            'remember_token'=> Str::random(10),
        ]);

        // Add User as HealthWorker
        $healthworker = HealthWorker::create([
            'name'          => $request->name,
            'surname'       => $request->surname,
            'age'           => $request->age,
            'gender'        => $request->gender,
            'cadre'         => $request->cadre,
            'department'    => $request->department,
        ]);
        return new HealthWorkerResource($healthworker);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $healthworker = HealthWorker::firstOrFail($id);
        if (Auth::user()->isHealthWorker()) {
            return new HealthWorkerResource($healthworker);
        }
        return  response()->json(["message" => "Forbidden"], 403);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
