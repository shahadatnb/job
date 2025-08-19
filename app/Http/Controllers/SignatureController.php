<?php

namespace App\Http\Controllers;

use App\Models\Signature;
use App\Models\JobSignature;
use App\Models\Job;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Calculation\MathTrig\Sign;

class SignatureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = ['sjob_id' => ''];
        $signatures = Signature::all();
        $jobs = Job::latest()->pluck('title', 'id')->take(50);
        $signature_arr = Signature::OrderBy('name', 'asc')->pluck('name', 'id')->toArray();

        $jobSignature = [];
        if (!empty($request->sjob_id)) {
            $data['sjob_id'] = $request->sjob_id;
            $jobSignature = JobSignature::where('job_id', $data['sjob_id'])->with('signature')->orderBy('serial', 'asc')->get();
        }

        return view('admin.signature.index', compact('signatures', 'jobs', 'signature_arr', 'data', 'jobSignature'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.signature.createOrEdit');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
        ]);

        $signature = new Signature();
        $signature->name = $request->name;
        $signature->description = $request->description;
        $signature->save();
        session()->flash('success', 'Signature created successfully');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Signature $signature)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Signature $signature)
    {
        return view('admin.signature.createOrEdit', ['signature' => $signature]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Signature $signature)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
        ]);

        $signature->name = $request->name;
        $signature->description = $request->description;
        $signature->save();
        session()->flash('success', 'Signature updated successfully');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Signature $signature)
    {
        $signature->delete();
        session()->flash('success', 'Signature deleted successfully');
        return redirect()->back();
    }


    public function add(Request $request)
    {
        $request->validate([
            'job_id' => 'required',
            'signature_id' => 'required',
        ]);

        $jobSignature = new JobSignature();
        $jobSignature->job_id = $request->job_id;
        $jobSignature->signature_id = $request->signature_id;
        $jobSignature->save();
        session()->flash('success', 'Signature added successfully');
        return redirect()->back();
    }

    public function delete($id)
    {
        $jobSignature = JobSignature::find($id);
        $jobSignature->delete();
        session()->flash('success', 'Signature removed successfully');
        return redirect()->back();
    }

    public function serial(Request $request)
    {
        $ids = explode(',', $request->ids);
        foreach($ids as $key=>$id){
            $data = JobSignature::findOrFail($id);
            $data->serial = $key;
            $data->save();
        }
        return response()->json(array('msg'=> $ids), 200);
    }
}
