<?php

namespace App\Http\Controllers;

use App\Models\EduLevelGroup;
use Illuminate\Http\Request;
use App\Models\EduLevel;
use App\Models\StudentEducation;

class EduLevelGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $edu_level_groups = EduLevelGroup::orderBy('edu_level_id','asc')->orderBy('sl','asc')->get();
        $exams = EduLevel::where('is_active', 1)->pluck('name', 'id');
        return view('admin.edu_level_group.index', compact('edu_level_groups', 'exams'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $exams = EduLevel::where('is_active', 1)->pluck('name', 'id');
        return view('admin.edu_level_group.createOrEdit', compact('exams'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'edu_level_id' => 'required',
            'sl' => 'nullable|numeric|max:100',
        ]);
        $eduLevelGroup = new EduLevelGroup;
        $eduLevelGroup->name = $request->name;
        $eduLevelGroup->edu_level_id = $request->edu_level_id;
        $eduLevelGroup->sl = $request->sl;
        $eduLevelGroup->is_active = 1;
        $eduLevelGroup->save();
        session()->flash('success', 'Successfully Created');
        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(EduLevelGroup $eduLevelGroup)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EduLevelGroup $eduLevelGroup)
    {
        $exams = EduLevel::where('is_active', 1)->pluck('name', 'id');
        return view('admin.edu_level_group.createOrEdit', compact('eduLevelGroup', 'exams'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EduLevelGroup $eduLevelGroup)
    {
        $request->validate([
            'name' => 'required',
            'edu_level_id' => 'required',
            'sl' => 'nullable|numeric|max:100',
        ]);
        $eduLevelGroup->name = $request->name;
        $eduLevelGroup->edu_level_id = $request->edu_level_id;
        $eduLevelGroup->sl = $request->sl;
        $eduLevelGroup->is_active = $request->is_active;
        $eduLevelGroup->save();
        session()->flash('success', 'Successfully Updated');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EduLevelGroup $eduLevelGroup)
    {
        $count = StudentEducation::where('edu_level_group_id', $eduLevelGroup->id)->count();
        if ($count > 0) {
            session()->flash('error', 'This Board is in use');
            return back();
        }
        $eduLevelGroup->delete();
        session()->flash('success', 'Successfully Deleted');
        return back();
    }
}
