<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\JobApplication;
use App\Models\ApplicationStatus;
use App\Models\Job;
use App\Models\EduGroup;
use App\Models\JobSignature;
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

        $job = Job::find($request->job_id);
        
        if(!$job) {
            return response()->json(['status' => false, 'message' => 'Job not found']);
        }else{
            $check_duplicate = JobApplication::where('job_id', $job->id)->where('student_id', auth('student')->user()->id)->first();
            if($check_duplicate) {
                //return response()->json(['status' => false, 'message' => 'You have already applied for this job']);
                $validator->after(function ($validator) {
                    $validator->errors()->add('duplicate', 'You have already applied for this job');
                });
            }
        }

        // check job is active or not
        if($job->status == 0) {
            //return response()->json(['status' => false, 'message' => 'Job is not active']);
            $validator->after(function ($validator) {
                $validator->errors()->add('job', 'Job is not active');
            });            
        }

        // check job is expired or not
        if($job->last_date < date('Y-m-d')) {
            //return response()->json(['status' => false, 'message' => 'Job is expired']);
            $validator->after(function ($validator) {
                $validator->errors()->add('job_expired', 'Job is expired');
            });  
        }

        // age limit check
        $current_age = Carbon::parse($user->date_of_birth)->age; 
        //return response()->json(['status' => false, 'message' => $current_age]);
        if($job->age_min > $current_age || $job->age_max < $current_age) {
            //return response()->json(['status' => false, 'message' => 'You are not eligible for this job for age']);
            $validator->after(function ($validator) {
                $validator->errors()->add('age', 'You are not eligible for this job for age');
            });
        }

        // experience check
        $total_experience = 0;
        foreach ($user->employments as $employment):
            $length = Carbon::parse($employment->start_date)->diffInDays(Carbon::parse($employment->end_date));
            $total_experience += $length>0 ? number_format($length/365,1) : 0;
        endforeach;
        if($job->minimum_experience > $total_experience) {
            //return response()->json(['status' => false, 'message' => 'Your experience is not eligible for this job']);
            $validator->after(function ($validator) {
                $validator->errors()->add('experience', 'Your experience is not eligible for this job');
            });
        }

        // gender limit check
        if($job->gender != $user->gender && $job->gender != 'Any') {
            //return response()->json(['status' => false, 'message' => 'You are not eligible for this job for gender']);
            $validator->after(function ($validator) {
                $validator->errors()->add('gender', 'You are not eligible for this job for gender');
            });
        }


        // edu level limit check
        $education_status = true;
        $education_status2 = false;
        $education_levels = $user->educations->pluck('edu_level_id')->toArray();

        if(in_array($job->edu_level_id, $education_levels) == false) {
            $education_status = false;
            //return response()->json(['status' => false, 'message' => 'You are not eligible for this job for education level']);
        }

        // photo and signature check
        if($user->photo == '' || $user->signature == '') {
            //return response()->json(['status' => false, 'message' => 'Please upload your photo and signature']);
            $validator->after(function ($validator) {
                $validator->errors()->add('file', 'Please upload your photo and signature');
            });
        }

        // edu group limit check
        if($job->edu_group_any != 1) {
            $edu_level = $user->educations->where('edu_level_id', $job->edu_level_id)->first();
            if($edu_level){
                if(!in_array($edu_level->edu_group_id, json_decode($job->edu_group_ids))) {
                    $education_status = false;
                    //return response()->json(['status' => false, 'message' => 'You are not eligible for this job for education group']);
                }
            }else{
                $education_status = false;
            }
        }

        if($job->edu_level2_id != '') {
            $education_status2 = true;
            
            if(in_array($job->edu_level2_id, $education_levels) == false) {
                $education_status2 = false;
            }

            if($job->edu_group2_any != 1) {
                $edu_level2 = $user->educations->where('edu_level_id', $job->edu_level2_id)->first();
                if($edu_level2) {
                    if(!in_array($edu_level2->edu_group_id, json_decode($job->edu_group2_ids))) {
                        $education_status2 = false;
                    }
                }else{
                    $education_status2 = false;
                }
            }
        }

        if($education_status == false && $education_status2 == false) {
            //return response()->json(['status' => false, 'message' => 'You are not eligible for this job for education']);
            $validator->after(function ($validator) {
                $validator->errors()->add('experience', 'Your experience is not eligible for this job');
            });
        }

        // error message
        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()->all()]);
        }

        $job_application = new JobApplication();
        $job_application->job_id = $job->id;
        $job_application->student_id = auth('student')->user()->id;
        $job_application->age = Carbon::parse($user->date_of_birth)->diffInYears($job->last_date);
        $job_application->expected_salary = $request->expected_salary;
        $job_application->save();
        session()->forget('job_info');
        session()->flash('success','Job application submitted successfully');
        return response()->json(['status' => true, 'message' => 'Job application submitted successfully']);
    }

    public function set_session(Request $request)
    {
        $request->session()->put('job_info', ['job_id' => $request->job_id, 'job_title' => $request->job_title]);
        return response()->json(['status' => true, 'message' => 'Job application submitted successfully']);
    }

    public function job_detail($id)
    {
        $jobs = Job::where('status', 1)->whereDate('last_date', '>', date('Y-m-d'))->latest()->paginate(50);
        $job = Job::find($id);

        if($job->edu_level_id != ''){            
            $eduGroups = EduGroup::where('edu_level_id', $job->edu_level_id)->pluck('name', 'id')->toArray();
        }else{
            $eduGroups = [];
        }

        if($job->edu_level2_id != ''){            
            $eduGroups2 = EduGroup::where('edu_level_id', $job->edu_level2_id)->pluck('name', 'id')->toArray();
        }else{
            $eduGroups2 = [];
        }
        if(!$job) {
            abort(404);
        }
        return view('frontend.pages.job_detail', compact('job', 'jobs', 'eduGroups', 'eduGroups2'));
    }
    
    public function application(Request $request)
    {
        $data = ['job_id'=>'','status'=>'','job_title'=>'','email'=>'','phone'=>''];
        $jobs = Job::where('status', 1)->pluck('title', 'id');
        $applied_jobs = JobApplication::with('job')->with('student')->latest();
        $applicationStatus = ApplicationStatus::where('status', 1)->orderBy('serial', 'asc')->pluck('name', 'id');
        $jobSignature = [];
        if(!empty($request->job_id)) {
            $data['job_id'] = $request->job_id;
            $data['job_title'] = $jobs[$request->job_id];
            $applied_jobs = $applied_jobs->whereHas('job', function ($query) use ($request) {
                $query->where('id', $request->job_id);
            });
            $jobSignature = JobSignature::where('job_id', $data['job_id'])->with('signature')->orderBy('serial', 'asc')->get();
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

        if(!empty($request->status)) {
            $data['status'] = $request->status;
            $applied_jobs = $applied_jobs->where('status', $request->status);
        }

        $applied_jobs = $applied_jobs->paginate(300);
        return view('admin.job.applied_jobs', compact('applied_jobs', 'data', 'jobs','applicationStatus','jobSignature'));
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
