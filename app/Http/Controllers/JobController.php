<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\EduLevel;
use App\Models\EduGroup;
use App\Models\Designation;
use Illuminate\Http\Request;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $designations = Designation::where('status', 1)->pluck('name', 'id');
        $jobs = Job::latest()->paginate(50);
        return view('admin.job.index', compact('designations', 'jobs'));
    }
    
    public function create()
    {
        $exams = EduLevel::where('is_active', 1)->pluck('name', 'id');
        $designations = Designation::where('status', 1)->orderBy('serial', 'asc')->pluck('name', 'id');
        $eduGroups = [];
        return view('admin.job.createOrEdit', compact('designations', 'exams', 'eduGroups'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'designation_id' => 'nullable',
            'requirements' => 'required',
            'responsibility' => 'required',
            'compensation_other_benefits' => 'required',
            'age_min' => 'required',
            'age_max' => 'required',
            'minimum_experience' => 'required',
            'gender' => 'required',
            'edu_level_id' => 'required',
            //'edu_group_ids' => 'required',
            'edu_group_ids' => 'required_without:edu_group_any',
            'edu_group2_ids' => 'required_without:edu_group2_any',
        ],[
            'edu_group_ids.required_without' => 'Please select at least one education group',
        ]);

        $job = new Job();
        $job->title = $request->title;
        $job->designation_id = $request->designation_id;
        $job->requirements = $request->requirements;
        $job->responsibility = $request->responsibility;
        $job->compensation_other_benefits = $request->compensation_other_benefits;
        $job->vacancy = $request->vacancy;
        $job->job_nature = $request->job_nature;
        $job->location = $request->location;
        $job->last_date = $request->last_date;
        $job->age_min = $request->age_min;
        $job->age_max = $request->age_max;
        $job->gender = $request->gender;
        $job->minimum_experience = $request->minimum_experience;
        $job->edu_level_id = $request->edu_level_id;
        $job->edu_group_any = $request->edu_group_any;
        $job->edu_group_ids = json_encode($request->edu_group_ids);
        $job->edu_level2_id = $request->edu_level2_id;
        $job->edu_group2_any = $request->edu_group2_any;
        $job->edu_group2_ids = json_encode($request->edu_group2_ids);
        $job->salary = $request->salary;
        $job->nagotiable = $request->nagotiable;
        $job->status = 1;
        $job->save();

        session()->flash('success','Successfully Save');

        return redirect()->route('job.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Job $job)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Job $job)
    {
        $exams = EduLevel::where('is_active', 1)->orderBy('serial', 'asc')->pluck('name', 'id');
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

        $job->edu_group_ids = json_decode($job->edu_group_ids, true);
        $job->edu_group2_ids = json_decode($job->edu_group2_ids, true);

        $designations = Designation::where('status', 1)->pluck('name', 'id');
        return view('admin.job.createOrEdit', compact('job', 'designations', 'exams', 'eduGroups','eduGroups2'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Job $job)
    {
        $request->validate([
            'title' => 'required',
            'designation_id' => 'nullable',
            'requirements' => 'required',
            'responsibility' => 'required',
            'compensation_other_benefits' => 'required',
            'age_min' => 'required',
            'age_max' => 'required',
            'minimum_experience' => 'required',
            'gender' => 'required',
            'edu_level_id' => 'required',
            'edu_group_ids' => 'required_without:edu_group_any',
            'edu_group2_ids' => 'required_without:edu_group2_any',
        ],[
            'edu_group_ids.required_without' => 'Please select at least one education group',
        ]);

        //dd(json_encode($request->edu_group_ids));

        $job->title = $request->title;
        $job->designation_id = $request->designation_id;
        $job->requirements = $request->requirements;
        $job->responsibility = $request->responsibility;
        $job->compensation_other_benefits = $request->compensation_other_benefits;
        $job->vacancy = $request->vacancy;
        $job->location = $request->location;
        $job->job_nature = $request->job_nature;
        $job->last_date = $request->last_date;
        $job->age_min = $request->age_min;
        $job->age_max = $request->age_max;
        $job->minimum_experience = $request->minimum_experience;
        $job->gender = $request->gender;
        $job->edu_level_id = $request->edu_level_id;
        $job->edu_group_any = $request->edu_group_any;
        $job->edu_group_ids = json_encode($request->edu_group_ids);
        $job->edu_level2_id = $request->edu_level2_id;
        $job->edu_group2_any = $request->edu_group2_any;
        $job->edu_group2_ids = json_encode($request->edu_group2_ids);
        $job->salary = $request->salary;
        $job->nagotiable = $request->nagotiable;
        $job->status = $request->status;
        $job->save();

        session()->flash('success','Successfully Update');

        return redirect()->route('job.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Job $job)
    {
        $job->delete();
        session()->flash('success','Successfully Deleted');

        return redirect()->route('job.index');
    }
}
