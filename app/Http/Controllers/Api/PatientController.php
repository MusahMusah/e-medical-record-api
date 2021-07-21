<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Patient;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\PatientRequest;
use App\Http\Resources\PatientResource;

class PatientController extends Controller
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
    public function store(PatientRequest $request)
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

        // Add User as Patient
        $patient = Patient::create([
            'name'          => $request->name,
            'surname'       => $request->surname,
            'age'           => $request->age,
            'gender'        => $request->gender,
            'height'        => $request->height,
            'weight'        => $request->weight,
            'bmi'           => $request->weight / $request->height,
            'ward'          => $request->ward,
            'lga'           => $request->lga,
            'state'         => $request->state,
            'image'         => $request->image,
        ]);
        return new PatientResource($patient);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
