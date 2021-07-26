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
    public function allPatients(Request $request)
    {
        $byGender = $request->payload['genderFilter'] ?? [];
        $byAge =  $request->payload['ageFilter'] ?? [];
        $patients = Patient::withFilters($byGender, $byAge)->get();
        return PatientResource::collection($patients);
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

        // Handle File Upload
        if ($request->hasFile('image')) {
            // Get filename with the extension
            $filenameWithExt = $request->file('image')->getClientOriginalName();
            // Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just ext
            $extension = $request->file('image')->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore = $filename . '_' . time() . '.' . $extension;
            // Upload Image
            $path = $request->file('image')->storeAs('public/patients', $fileNameToStore);
            $path = str_replace('public', '', $path);
        } else {
            $path = 'patients/noimage.png';
        }

        // Add User as Patient
        $patient = Patient::create([
            'user_id'       => $user->id,
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
            'image'         => asset('storage'.$path),
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
        // find a patient and return all the patients information
        $patient = Patient::firstOrFail($id);
        return new PatientResource($patient);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PatientRequest $request, Patient $patient)
    {
        $patient->update([
            'name'            => $request->name,
            'surname'         => $request->surname,
            'age'             => $request->age,
            'gender'          => $request->gender,
            'height'           => $request->height,
            'weight'           => $request->weight,
            'bmi'           => $request->bmi,
            'ward'           => $request->ward,
            'lga'           => $request->lga,
            'state'           => $request->state,
        ]);
        // check for image in request
        if ($request->fill('image')) $patient->attachImage($request->image);
        return new PatientResource($patient);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Patient $patient)
    {
        // Find and delete patient record
        $patient->delete();
        return response()->json(['message' => 'Patient Record deleted'], 200);
    }
}
