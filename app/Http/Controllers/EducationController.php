<?php

namespace App\Http\Controllers;

use App\Models\StudentEducation;
use App\Models\EduBoard;
use App\Models\EduGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EducationController extends Controller
{

    public function edu_group(Request $request)
    {
        $groups = EduGroup::where('edu_level_id', $request->edu_level_id)->get('name', 'id');
        $boards = EduBoard::where('edu_level_id', $request->edu_level_id)->get('name', 'id');
        return response()->json(['status'=>true,'groups' => $groups, 'boards' => $boards]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'edu_level_id' => 'required',
            'edu_group_id' => 'required',
            'edu_board_id' => 'required',
            'passing_year' => 'required',
            'gpa' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()->all()]);
        }
        $edu = new StudentEducation();
        $edu->student_id = auth('student')->user()->id;
        $edu->edu_level_id = $request->edu_level_id;
        $edu->edu_group_id = $request->edu_group_id;
        $edu->edu_board_id = $request->edu_board_id;
        $edu->passing_year = $request->passing_year;
        $edu->gpa = $request->gpa;
        $edu->save();
        return response()->json(['status' => true, 'type'=> 'save', 'data'=> $edu, 'message' => 'Education saved successfully']);
    }
}
