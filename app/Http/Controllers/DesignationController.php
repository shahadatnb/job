<?php

namespace App\Http\Controllers;

use App\Models\Designation;
use Illuminate\Http\Request;

class DesignationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $designations = Designation::all();

        return view('admin.designation.index', ['designations' => $designations]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.designation.createOrEdit');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);
        
        $designation = new Designation();
        $designation->name = $request->name;
        $designation->serial = $request->serial;
        $designation->save();

        session()->flash('success','Successfully Save');

        return redirect()->route('designation.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Designation $designation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Designation $designation)
    {
        return view('admin.designation.createOrEdit', ['designation' => $designation]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Designation $designation)
    {
        $request->validate([
            'name' => 'required',
        ]);
        
        $designation->name = $request->name;
        $designation->serial = $request->serial;
        $designation->status = $request->status;
        $designation->save();

        session()->flash('success','Successfully Save');

        return redirect()->route('designation.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Designation $designation)
    {
        $designation->delete();
        session()->flash('success','Successfully Deleted');
        return redirect()->route('designation.index');
    }
}
