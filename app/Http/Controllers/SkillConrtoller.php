<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ApplicantSkill;
use Illuminate\Support\Facades\Validator;

class SkillConrtoller extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'skill' => 'required|string|max:50',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()]);
        }

        $applicant = auth('applicant')->user();
        $skill = new ApplicantSkill;
        $skill->skill = $request->skill;
        $skill->applicant_id = $applicant->id;
        $skill->save();
        return response()->json(['status' => true, 'skill' => $skill]);
    }

    public function destroy(Request $request)
    {
        $skill = $this->ownedOrFail(ApplicantSkill::class, $request->id);
        $skill->delete();
        return response()->json(['status' => true]);
    }

    public function list(Request $request)
    {
        $skills = ApplicantSkill::groupBy('skill')->pluck('skill');
        return response()->json(['status' => true, 'skills' => $skills]);
    }
}
