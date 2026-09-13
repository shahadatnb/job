<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\References;

class ReferencesController extends Controller
{
    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'designation' => 'required',
            'organization' => 'required:date',
            'email' => 'nullable|email',
            'relation' => 'required',
            'mobile' => 'required',
            'address' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()->all()]);
        }

        $applicant = auth('applicant')->user();
        $reference = new References();
        $reference->applicant_id = $applicant->id;
        $reference->name = $request->name;
        $reference->designation = $request->designation;
        $reference->organization = $request->organization;
        $reference->email = $request->email;
        $reference->relation = $request->relation;
        $reference->mobile = $request->mobile;
        $reference->address = $request->address;
        $reference->save();

        return response()->json(['status' => true, 'type'=> 'save', 'reference'=> $reference, 'message' => 'Education saved successfully']);
    }

    public function update(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'designation' => 'required',
            'organization' => 'required:date',
            'email' => 'nullable|email',
            'relation' => 'required',
            'mobile' => 'required',
            'address' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()->all()]);
        }

        $reference = $this->ownedOrFail(References::class, $request->id);
        $reference->name = $request->name;
        $reference->designation = $request->designation;
        $reference->organization = $request->organization;
        $reference->email = $request->email;
        $reference->relation = $request->relation;
        $reference->mobile = $request->mobile;
        $reference->address = $request->address;
        $reference->save();

        return response()->json(['status' => true, 'type'=> 'update', 'reference'=> $reference, 'message' => 'Education updated successfully']);
    }

    public function edit(Request $request){
        $reference = $this->ownedOrFail(References::class, $request->id);
        return response()->json(['status' => true, 'type'=> 'edit', 'reference'=> $reference]);
    }

    public function destroy(Request $request){
        $reference = $this->ownedOrFail(References::class, $request->id);
        $reference->delete();
        return response()->json(['status' => true, 'type'=> 'delete', 'message' => 'Employment deleted successfully']);
    }
}
