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
        $groups = EduGroup::where('edu_level_id', $request->edu_level_id)->get();
        $boards = EduBoard::where('edu_level_id', $request->edu_level_id)->get();
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
        
        $education = StudentEducation::find($edu->id);
        $education->exam_name = $education->exam->name;
        $education->board_name = $education->board->name;
        $education->group_name = $education->group->name; 

        return response()->json(['status' => true, 'type'=> 'save', 'education'=> $education, 'message' => 'Education saved successfully']);
    }

    public function edit(Request $request)
    {
        $education = StudentEducation::find($request->id);
        $groups = EduGroup::where('edu_level_id', $education->edu_level_id)->get();
        $boards = EduBoard::where('edu_level_id', $education->edu_level_id)->get();
        return response()->json(['status' => true, 'type'=> 'edit', 'education'=> $education, 'groups' => $groups, 'boards' => $boards]);
    }

    public function update(Request $request)
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
        $edu = StudentEducation::find($request->id);
        $edu->edu_level_id = $request->edu_level_id;
        $edu->edu_group_id = $request->edu_group_id;
        $edu->edu_board_id = $request->edu_board_id;
        $edu->passing_year = $request->passing_year;
        $edu->gpa = $request->gpa;
        $edu->save();
        
        $education = StudentEducation::find($edu->id);
        $education->exam_name = $education->exam->name;
        $education->board_name = $education->board->name;
        $education->group_name = $education->group->name;   

        return response()->json(['status' => true, 'type'=> 'update', 'education'=> $education, 'message' => 'Education updated successfully']);
    }

    public function destroy(Request $request)
    {
        $education = StudentEducation::find($request->id);
        $education->delete();
        return response()->json(['status' => true, 'type'=> 'delete', 'message' => 'Education deleted successfully']);
    }
}
