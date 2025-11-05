<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $departments = Department::all();
        return view('admin.department.index', compact('departments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.department.createOrEdit');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:departments,name',
            'serial' => 'required|numeric',
        ]);
        
        $department = new Department();
        $department->name = $request->name;
        $department->serial = $request->serial;
        $department->save();

        session()->flash('success','Successfully Save');

        return redirect()->route('department.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(department $department)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Department $department)
    {
        return view('admin.department.createOrEdit', ['department' => $department]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Department $department)
    {
        $request->validate([
            'name' => 'required|unique:departments,name,'.$department->id,
            'serial' => 'required|numeric',
        ]);
        
        $department->name = $request->name;
        $department->serial = $request->serial;
        $department->status = $request->status;
        $department->save();

        session()->flash('success','Successfully Save');

        return redirect()->route('department.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Department $department)
    {
        $department->delete();
        session()->flash('success','Successfully Deleted');
        return redirect()->route('designation.index');
    }
}
