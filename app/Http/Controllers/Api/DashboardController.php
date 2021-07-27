<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\HealthWorker;
use App\Models\Patient;
use App\Models\PatientEncounter;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        return response([
            'doctorsCounts'     => Count(HealthWorker::all()),
            'patientCounts'     => Count(Patient::all()),
            'totalEncounter'    => Count(PatientEncounter::all()),
            'analyticsByAge'    =>
            [ 'data' => [
                Count(Patient::whereBetween('age', [0, 10])->get()),
                Count(Patient::whereBetween('age', [11, 20])->get()),
                Count(Patient::whereBetween('age', [21, 30])->get()),
                Count(Patient::whereBetween('age', [31, 40])->get()),
                Count(Patient::whereBetween('age', [41, 50])->get()),
                Count(Patient::whereBetween('age', [51, 60])->get()),
                Count(Patient::whereBetween('age', [61, 70])->get()),
                Count(Patient::whereBetween('age', [71, 80])->get()),
                Count(Patient::whereBetween('age', [81, 90])->get()),
                Count(Patient::where('age', '>', '91')->get()),
            ]],
            'analyticsByGender' => [
                ["Gender Analytics", "By percentage ratio"],
                ['Male', Count(Patient::where('gender', 'male')->get())],
                ['Female', Count(Patient::where('gender', 'female')->get())],
            ],
        ], 200);
    }
}
