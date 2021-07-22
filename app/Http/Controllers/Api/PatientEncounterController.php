<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PatientEncounterRequest;
use App\Http\Requests\PatientRequest;
use App\Http\Resources\PatientEncounterResource;
use App\Http\Resources\PatientResource;
use App\Models\PatientEncounter;
use Illuminate\Http\Request;

class PatientEncounterController extends Controller
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
    public function store(PatientEncounterRequest $request, PatientEncounter $encounter)
    {
        $encounter->create($request->validated());
        return new PatientEncounterResource($encounter);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(PatientEncounter $encounter)
    {
        return new PatientResource($encounter);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PatientRequest $encounter)
    {
        $encounter->update($request->validated());
        return new PatientEncounterResource($encounter);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(PatientEncounter $encounter)
    {
        $encounter->delete();
        return response()->json(['message' => 'Encounter Record deleted'], 200);
    }
}
