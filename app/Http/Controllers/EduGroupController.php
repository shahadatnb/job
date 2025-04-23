<?php

namespace App\Http\Controllers;

use App\Models\EduGroup;
use App\Models\EduLevel;
use App\Models\StudentEducation;
use Illuminate\Http\Request;

class EduGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $exams = EduLevel::where('is_active', 1)->pluck('name', 'id');
        $eduGroups = EduGroup::all();
        return view('admin.edu_group.index', compact('eduGroups', 'exams'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $exams = EduLevel::where('is_active', 1)->pluck('name', 'id');
        return view('admin.edu_group.createOrEdit', compact('exams'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'edu_level_id' => 'required',
        ]);
        $eduGroup = new EduGroup;
        $eduGroup->name = $request->name;
        $eduGroup->edu_level_id = $request->edu_level_id;
        $eduGroup->is_active = 1;
        $eduGroup->save();
        session()->flash('success', 'Successfully Created');
        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(EduGroup $eduGroup)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EduGroup $eduGroup)
    {
        $exams = EduLevel::where('is_active', 1)->pluck('name', 'id');
        return view('admin.edu_group.createOrEdit', compact('eduGroup', 'exams'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EduGroup $eduGroup)
    {
        $request->validate([
            'name' => 'required',
            'edu_level_id' => 'required',
        ]);
        $eduGroup->name = $request->name;
        $eduGroup->edu_level_id = $request->edu_level_id;
        $eduGroup->is_active = $request->is_active;
        $eduGroup->save();
        session()->flash('success', 'Successfully Updated');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EduGroup $eduGroup)
    {
        $count = StudentEducation::where('edu_group_id', $eduGroup->id)->count();
        if ($count > 0) {
            session()->flash('error', 'This Group is in use');
            return back();
        }
        $eduGroup->delete();
        session()->flash('success', 'Successfully Deleted');
        return back();
    }
}
