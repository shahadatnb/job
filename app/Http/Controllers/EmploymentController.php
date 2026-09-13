<?php

namespace App\Http\Controllers;

use App\Models\ApplicantEmployment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class EmploymentController extends Controller
{
    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'company_name' => 'required',
            'job_title' => 'required',
            'start_date' => 'required:date',
            'end_date' => 'required_if:is_current,0|date',
            'job_description' => 'required',
            'company_location' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()->all()]);
        }

        $applicant = auth('applicant')->user();
        $applicant_employment = new ApplicantEmployment();
        $applicant_employment->applicant_id = $applicant->id;
        $applicant_employment->company_name = $request->company_name;
        $applicant_employment->job_title = $request->job_title;
        $applicant_employment->start_date = Carbon::parse($request->start_date)->format('Y-m-d');
        $applicant_employment->end_date = $request->is_current ? null : Carbon::parse($request->end_date)->format('Y-m-d');// $request->end_date;
        $applicant_employment->job_description = $request->job_description;
        $applicant_employment->company_location = $request->company_location;
        $applicant_employment->is_current = $request->is_current ? 1 : 0;
        $applicant_employment->save();
        return response()->json(['status' => true, 'type'=> 'save', 'employment'=> $applicant_employment, 'message' => 'Education saved successfully']);
    }

    public function update(Request $request){
        $validator = Validator::make($request->all(), [
            'company_name' => 'required',
            'job_title' => 'required',
            'start_date' => 'required:date',
            'end_date' => 'required_if:is_current,0|date',
            'job_description' => 'required',
            'company_location' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()->all()]);
        }

        $applicant_employment = $this->ownedOrFail(ApplicantEmployment::class, $request->id);
        $applicant_employment->company_name = $request->company_name;
        $applicant_employment->job_title = $request->job_title;
        $applicant_employment->start_date = Carbon::parse($request->start_date)->format('Y-m-d');
        $applicant_employment->end_date = $request->is_current ? null : Carbon::parse($request->end_date)->format('Y-m-d');// $request->end_date;
        $applicant_employment->job_description = $request->job_description;
        $applicant_employment->company_location = $request->company_location;
        $applicant_employment->is_current = $request->is_current ? 1 : 0;
        $applicant_employment->save();
        return response()->json(['status' => true, 'type'=> 'update', 'employment'=> $applicant_employment, 'message' => 'Education updated successfully']);
    }

    public function edit(Request $request){
        $applicant_employment = $this->ownedOrFail(ApplicantEmployment::class, $request->id);
        return response()->json(['status' => true, 'type'=> 'edit', 'employment'=> $applicant_employment]);
    }

    public function destroy(Request $request){
        $applicant_employment = $this->ownedOrFail(ApplicantEmployment::class, $request->id);
        $applicant_employment->delete();
        return response()->json(['status' => true, 'type'=> 'delete', 'message' => 'Employment deleted successfully']);
    }
}
