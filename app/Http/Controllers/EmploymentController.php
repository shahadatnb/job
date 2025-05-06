<?php

namespace App\Http\Controllers;

use App\Models\StudentEmployment;
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
            'end_date' => 'required',
            'job_description' => 'required',
            'company_location' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()->all()]);
        }

        $student = auth('student')->user();
        $student_employment = new StudentEmployment();
        $student_employment->student_id = $student->id;
        $student_employment->company_name = $request->company_name;
        $student_employment->job_title = $request->job_title;
        $student_employment->start_date = Carbon::parse($request->start_date)->format('Y-m-d');
        $student_employment->end_date = Carbon::parse($request->end_date)->format('Y-m-d');// $request->end_date;
        $student_employment->job_description = $request->job_description;
        $student_employment->company_location = $request->company_location;
        $student_employment->save();
        return response()->json(['status' => true, 'type'=> 'save', 'employment'=> $student_employment, 'message' => 'Education saved successfully']);
    }

    public function update(Request $request){
        $validator = Validator::make($request->all(), [
            'company_name' => 'required',
            'job_title' => 'required',
            'start_date' => 'required:date',
            'end_date' => 'required|date',
            'job_description' => 'required',
            'company_location' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()->all()]);
        }

        $student_employment = StudentEmployment::find($request->id);
        $student_employment->company_name = $request->company_name;
        $student_employment->job_title = $request->job_title;
        $student_employment->start_date = $request->start_date;
        $student_employment->end_date = $request->end_date;
        $student_employment->job_description = $request->job_description;
        $student_employment->company_location = $request->company_location;
        $student_employment->save();
        return response()->json(['status' => true, 'type'=> 'update', 'employment'=> $student_employment, 'message' => 'Education updated successfully']);
    }

    public function destroy(Request $request){
        $student_employment = StudentEmployment::find($request->id);
        $student_employment->delete();
        return response()->json(['status' => true, 'type'=> 'delete', 'message' => 'Employment deleted successfully']);
    }
}
