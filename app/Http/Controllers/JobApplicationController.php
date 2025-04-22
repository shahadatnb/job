<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\JobApplication;
use App\Models\Job;

class JobApplicationController extends Controller
{
    public function apply(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'job_id' => 'required',
            'expected_salary' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()->all()]);
        }

        $job = Job::find($request->job_id);

        if(!$job) {
            return response()->json(['status' => false, 'message' => 'Job not found']);
        }else{
            $check_duplicate = JobApplication::where('job_id', $job->id)->where('student_id', auth('student')->user()->id)->first();
            if($check_duplicate) {
                return response()->json(['status' => false, 'message' => 'You have already applied for this job']);
            }
        }

        $job_application = new JobApplication();
        $job_application->job_id = $job->id;
        $job_application->student_id = auth('student')->user()->id;
        $job_application->expected_salary = $request->expected_salary;
        $job_application->save();
        return response()->json(['status' => true, 'message' => 'Job application submitted successfully']);
    }
}
