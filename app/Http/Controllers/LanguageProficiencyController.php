<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\LanguageProficiency;

class LanguageProficiencyController extends Controller
{
    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'language' => 'required',
            'reading' => 'required',
            'writing' => 'required:date',
            'speaking' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()->all()]);
        }

        $applicant = auth('applicant')->user();
        $language = new LanguageProficiency();
        $language->applicant_id = $applicant->id;
        $language->language = $request->language;
        $language->reading = $request->reading;
        $language->writing = $request->writing;
        $language->speaking = $request->speaking;
        $language->save();
        return response()->json(['status' => true, 'type'=> 'save', 'language'=> $language, 'message' => 'Education saved successfully']);
    }

    public function update(Request $request){
        $validator = Validator::make($request->all(), [
            'language' => 'required',
            'reading' => 'required',
            'writing' => 'required:date',
            'speaking' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()->all()]);
        }

        $language = $this->ownedOrFail(LanguageProficiency::class, $request->id);
        $language->language = $request->language;
        $language->reading = $request->reading;
        $language->writing = $request->writing;
        $language->speaking = $request->speaking;
        $language->save();

        return response()->json(['status' => true, 'type'=> 'update', 'language'=> $language, 'message' => 'Education updated successfully']);
    }

    public function edit(Request $request){
        $language = $this->ownedOrFail(LanguageProficiency::class, $request->id);
        return response()->json(['status' => true, 'type'=> 'edit', 'language'=> $language]);
    }

    public function destroy(Request $request){
        $language = $this->ownedOrFail(LanguageProficiency::class, $request->id);
        $language->delete();
        return response()->json(['status' => true, 'type'=> 'delete', 'message' => 'Employment deleted successfully']);
    }
}
