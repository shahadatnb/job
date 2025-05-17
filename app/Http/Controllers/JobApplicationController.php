<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\JobApplication;
use App\Models\ApplicationStatus;
use App\Models\Job;
use Carbon\Carbon;

class JobApplicationController extends Controller
{
    public function apply(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'job_id' => 'required',
            'expected_salary' => 'required|numeric',
        ]);

        $user = auth('student')->user();

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()->all()]);
        }

        $job = Job::find($request->job_id);

        // check job is active or not
        if($job->status == 0) {
            return response()->json(['status' => false, 'message' => 'Job is not active']);
        }

        // check job is expired or not
        if($job->last_date < date('Y-m-d')) {
            return response()->json(['status' => false, 'message' => 'Job is expired']);
        }

        // age limit check
        $current_age = Carbon::parse($user->date_of_birth)->age; 
        //return response()->json(['status' => false, 'message' => $current_age]);
        if($job->age_min > $current_age || $job->age_max < $current_age) {
            return response()->json(['status' => false, 'message' => 'You are not eligible for this job for age']);
        }

        // gender limit check
        if($job->gender != $user->gender && $job->gender != 'Any') {
            return response()->json(['status' => false, 'message' => 'You are not eligible for this job for gender']);
        }

        // edu level limit check
        if($job->edu_level_id != $user->educations->where('edu_level_id', $job->edu_level_id)->first()->edu_level_id) {
            return response()->json(['status' => false, 'message' => 'You are not eligible for this job for education level']);
        }

        // edu group limit check
        if($job->edu_group_any != 1) {
            //dd(json_decode($job->edu_group_ids));
            if(!in_array($user->educations->where('edu_level_id', $job->edu_level_id)->first()->edu_group_id, json_decode($job->edu_group_ids))) {
                return response()->json(['status' => false, 'message' => 'You are not eligible for this job for education group']);
            }
        }

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
        $job_application->age = Carbon::parse($user->date_of_birth)->diffInYears($job->last_date);
        $job_application->expected_salary = $request->expected_salary;
        $job_application->save();
        session()->forget('job_info');
        return response()->json(['status' => true, 'message' => 'Job application submitted successfully']);
    }

    public function set_session(Request $request)
    {
        $request->session()->put('job_info', ['job_id' => $request->job_id, 'job_title' => $request->job_title]);
        return response()->json(['status' => true, 'message' => 'Job application submitted successfully']);
    }

    public function job_detail($id)
    {
        $job = Job::find($id);
        if(!$job) {
            abort(404);
        }
        return view('frontend.pages.job_detail', compact('job'));
    }
    
    public function application(Request $request)
    {
        $data = ['dasignation_id'=>''];
        $jobs = Job::where('status', 1)->pluck('title', 'id');
        $applied_jobs = JobApplication::with('job')->latest();
        $applicationStatus = ApplicationStatus::where('status', 1)->orderBy('serial', 'asc')->pluck('name', 'id');
        if(!empty($request->job_id)) {
            $data['job_id'] = $request->job_id;
            $applied_jobs = $applied_jobs->whereHas('job', function ($query) use ($request) {
                $query->where('id', $request->job_id);
            });
        }
        if(!empty($request->email)) {
            $data['email'] = $request->email;
            $applied_jobs = $applied_jobs->whereHas('student', function ($query) use ($request) {
                $query->where('email', $request->email);
            });
        }
        if(!empty($request->phone)) {
            $data['phone'] = $request->phone;
            $applied_jobs = $applied_jobs->whereHas('student', function ($query) use ($request) {
                $query->where('phone', $request->phone);
            });
        }

        $applied_jobs = $applied_jobs->paginate(100);
        return view('admin.job.applied_jobs', compact('applied_jobs', 'data', 'jobs','applicationStatus'));
    }

    public function application_status(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required',
            'candidate_ids' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()->all()]);
        }
        //dd($request->all());
        $candidate_ids = explode(',', $request->candidate_ids);
        // $application_ids = json_decode($request->candidate_ids, true);
        // foreach ($application_ids as $application_id) {
        //     JobApplication::where('id', $application_id)->update(['status' => $request->application_status_id]);
        // }
        JobApplication::whereIn('id', $candidate_ids)->update(['status' => $request->status]);
        return response()->json(['status' => true, 'message' => 'Application status updated successfully']);
        //return $request->all();
    }
}
