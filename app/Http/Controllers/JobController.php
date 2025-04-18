<?php

namespace App\Http\Controllers;

use App\Models\Job;
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

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $designations = Designation::where('status', 1)->pluck('name', 'id');
        return view('admin.job.createOrEdit', compact('designations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'designation_id' => 'required',
            'description' => 'required',
            'responsibility' => 'required',
            'qualifications' => 'required',
        ]);

        $job = new Job();
        $job->designation_id = $request->designation_id;
        $job->description = $request->description;
        $job->responsibility = $request->responsibility;
        $job->qualifications = $request->qualifications;
        $job->vacancy = $request->vacancy;
        $job->job_nature = $request->job_nature;
        $job->last_date = $request->last_date;
        $job->age_limit = $request->age_limit;
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
        $designations = Designation::where('status', 1)->pluck('name', 'id');
        return view('admin.job.createOrEdit', compact('job', 'designations'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Job $job)
    {
        $request->validate([
            'designation_id' => 'required',
            'description' => 'required',
            'responsibility' => 'required',
            'qualifications' => 'required',
        ]);

        $job->designation_id = $request->designation_id;
        $job->description = $request->description;
        $job->responsibility = $request->responsibility;
        $job->qualifications = $request->qualifications;
        $job->vacancy = $request->vacancy;
        $job->job_nature = $request->job_nature;
        $job->last_date = $request->last_date;
        $job->age_limit = $request->age_limit;
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
