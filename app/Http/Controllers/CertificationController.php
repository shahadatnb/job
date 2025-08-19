<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\ProfessionalCertificate;
use Carbon\Carbon;

class CertificationController extends Controller
{
    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'certification' => 'required',
            'institute' => 'required',
            'start_date' => 'required:date',
            'end_date' => 'required',
            'location' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()->all()]);
        }

        $student = auth('student')->user();
        $professional_certificate = new ProfessionalCertificate();
        $professional_certificate->student_id = $student->id;
        $professional_certificate->certification = $request->certification;
        $professional_certificate->institute = $request->institute;
        $professional_certificate->location = $request->location;
        $professional_certificate->start_date = Carbon::parse($request->start_date)->format('Y-m-d');
        $professional_certificate->end_date = Carbon::parse($request->end_date)->format('Y-m-d');// $request->end_date;
        $professional_certificate->save();
        $professional_certificate->start_date = Carbon::parse($professional_certificate->start_date)->format('d-m-Y');
        $professional_certificate->end_date = Carbon::parse($professional_certificate->end_date)->format('d-m-Y');
        return response()->json(['status' => true, 'type'=> 'save', 'professional'=> $professional_certificate, 'message' => 'Education saved successfully']);
    }

    public function update(Request $request){
        $validator = Validator::make($request->all(), [
            'certification' => 'required',
            'institute' => 'required',
            'start_date' => 'required:date',
            'end_date' => 'required',
            'location' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()->all()]);
        }

        $professional_certificate = ProfessionalCertificate::find($request->id);
        $professional_certificate->certification = $request->certification;
        $professional_certificate->institute = $request->institute;
        $professional_certificate->start_date = Carbon::parse($request->start_date)->format('Y-m-d');
        $professional_certificate->end_date = Carbon::parse($request->end_date)->format('Y-m-d');// $request->end_date;
        $professional_certificate->location = $request->location;
        $professional_certificate->save();
        $professional_certificate->start_date = Carbon::parse($professional_certificate->start_date)->format('d-m-Y');
        $professional_certificate->end_date = Carbon::parse($professional_certificate->end_date)->format('d-m-Y');
        return response()->json(['status' => true, 'type'=> 'update', 'professional'=> $professional_certificate, 'message' => 'Education updated successfully']);
    }

    public function edit(Request $request){
        $professional_certificate = ProfessionalCertificate::find($request->id);
        $professional_certificate->start_date = Carbon::parse($professional_certificate->start_date)->format('d-m-Y');
        $professional_certificate->end_date = Carbon::parse($professional_certificate->end_date)->format('d-m-Y');
        return response()->json(['status' => true, 'type'=> 'edit', 'professional'=> $professional_certificate]);
    }

    public function destroy(Request $request){
        $professional_certificate = ProfessionalCertificate::find($request->id);
        $professional_certificate->delete();
        return response()->json(['status' => true, 'type'=> 'delete', 'message' => 'Employment deleted successfully']);
    }
}
