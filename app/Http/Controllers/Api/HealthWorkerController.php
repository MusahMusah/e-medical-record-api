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
        $healthworkers = HealthWorker::orderByDesc('created_at')->get();
        return HealthWorkerResource::collection($healthworkers);
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
            'name'              => $request->name,
            'email'             => $request->email,
            'is_health_worker'  => true,
            'password'          => Hash::make($request->password),
            'email_verified_at' => now(),
            'remember_token'    => Str::random(10),
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
            $path = $request->file('image')->storeAs('public/healthworkers', $fileNameToStore);
            $path = str_replace('public', '', $path);
        } else {
            $path = 'healthworker/noimage.png';
        }

        // Add User as HealthWorker
        $healthworker = HealthWorker::create([
            'user_id'       => $user->id,
            'name'          => $request->name,
            'surname'       => $request->surname,
            'age'           => $request->age,
            'gender'        => $request->gender,
            'cadre'         => $request->cadre,
            'department'    => $request->department,
            'image'         => asset('storage'.$path),
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
        $healthworker = HealthWorker::findOrFail($id);
        return new HealthWorkerResource($healthworker);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(HealthWorkerRequest $request, HealthWorker $healthworker)
    {
        $healthworker->update([
            'name'            => $request->name,
            'surname'         => $request->surname,
            'age'             => $request->age,
            'gender'          => $request->gender,
            'cadre'           => $request->cadre,
            'department'      => $request->department,
        ]);
        // check for image in request
        if ($request->fill('image')) $healthworker->attachImage($request->image);
        return new HealthWorkerResource($healthworker);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(HealthWorker $healthworker)
    {
        $healthworker->delete();
        return response()->json(['message' => 'Health Worker Record deleted'], 200);
    }
}
