<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\ApplicantResult;
use App\Models\JobApplication;
use App\Models\ApplicationStatus;
use App\Models\Job;
use Illuminate\Support\Facades\App;

class ApplicantResultController extends Controller
{
    public function result_entry(Request $request)
    {
        $data = ['job_id'=>'','status'=>'','job_title'=>'','email'=>'','phone'=>''];
        $jobs = Job::where('status', 1)->pluck('title', 'id');
        $applicationStatus = ApplicationStatus::where('status', 1)->orderBy('serial', 'asc')->pluck('name', 'id');
        $applied_jobs = [];

        if(!empty($request->job_id) && !empty($request->status)) {
            $data['job_id'] = $request->job_id;
            $data['job_title'] = $jobs[$request->job_id];
            $data['status'] = $request->status;

            $applied_jobs = JobApplication::with('job','applicant','result')->where('job_id', $request->job_id)->where('status', $request->status)->latest();
            if(!empty($request->email)) {
                $data['email'] = $request->email;
                $applied_jobs = $applied_jobs->whereHas('applicant', function ($query) use ($request) {
                    $query->where('email', $request->email);
                });
            }
            if(!empty($request->phone)) {
                $data['phone'] = $request->phone;
                $applied_jobs = $applied_jobs->whereHas('applicant', function ($query) use ($request) {
                    $query->where('phone', $request->phone);
                });
            }        

            $applied_jobs = $applied_jobs->paginate(100);
        }

        return view('admin.job.result_entry', compact('applied_jobs', 'data', 'jobs','applicationStatus'));
    }

    public function result_save(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'preferred_salary.*' => 'nullable|numeric',
            'marks.*' => 'nullable|numeric',
            'position.*' => 'nullable|numeric',
        ]);

        //return $request->all();

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()->all()]);
        }

        foreach ($request->application_id as $key => $application_id) {
            ApplicantResult::updateOrCreate(
                ['application_id' => $application_id],
                [
                    'present_salary' => $request->present_salary[$key],
                    'preferred_salary' => $request->preferred_salary[$key],
                    'marks' => $request->marks[$key],
                    'position' => $request->position[$key],
                ]
            );
        }

        return response()->json(['status' => true, 'message' => 'Result updated successfully']);

    }
}
