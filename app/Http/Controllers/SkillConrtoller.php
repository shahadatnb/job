<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StudentSkill;
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

        $student = auth('student')->user();
        $skill = new StudentSkill;
        $skill->skill = $request->skill;
        $skill->student_id = $student->id;
        $skill->save();
        return response()->json(['status' => true, 'skill' => $skill]);
    }

    public function destroy(Request $request)
    {
        $skill = StudentSkill::find($request->id);
        $skill->delete();
        return response()->json(['status' => true]);
    }

    public function list(Request $request)
    {
        $skills = StudentSkill::groupBy('skill')->pluck('skill');
        return response()->json(['status' => true, 'skills' => $skills]);
    }
}
