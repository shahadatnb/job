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
            'edu_board_id' => 'nullable',
            'university' => 'nullable',
            'passing_year' => 'required',
            'result_type' => 'required',
            'result_gpa' => 'nullable|required_if:result_type,gpa|numeric|max:5',
            'out_of' => 'nullable|required_if:result_type,gpa|numeric|max:5',
            'result_division' => 'required_if:result_type,division',
            'result_pass' => 'required_if:result_type,pass',
        ],[
            'result_gpa.required_if' => 'GPA is required',
            'out_of.required_if' => 'Out of is required',
            'result_division.required_if' => 'Division is required',
            'result_pass.required_if' => 'Pass is required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()->all()]);
        }

        $edu = new StudentEducation();

        if($request->result_type == 'gpa'){
            $result = $request->result_gpa;
            $edu->out_of = $request->out_of;
        }elseif($request->result_type == 'division'){
            $result = $request->result_division;
        }else{
            $result = $request->result_pass;
        }

        $edu->student_id = auth('student')->user()->id;
        $edu->edu_level_id = $request->edu_level_id;
        $edu->edu_group_id = $request->edu_group_id;
        $edu->edu_board_id = $request->edu_board_id;
        $edu->university = $request->university;
        $edu->passing_year = $request->passing_year;
        $edu->result_type = $request->result_type;
        $edu->result = $result;
        $edu->save();
        
        $education = StudentEducation::find($edu->id);
        $education->exam_name = $education->exam? $education->exam->name : '';
        $education->board_name = $education->board? $education->board->name : $education->university;
        $education->group_name = $education->group? $education->group->name : ''; 

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
            'edu_board_id' => 'nullable',
            'university' => 'nullable',
            'passing_year' => 'required',
            'result_type' => 'required',
            'result_gpa' => 'nullable|required_if:result_type,gpa|numeric|max:5',
            'out_of' => 'nullable|required_if:result_type,gpa|numeric|max:5',
            'result_division' => 'required_if:result_type,division',
            'result_pass' => 'required_if:result_type,pass',
        ],[
            'result_gpa.required_if' => 'GPA is required',
            'out_of.required_if' => 'Out of is required',
            'result_division.required_if' => 'Division is required',
            'result_pass.required_if' => 'Pass is required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()->all()]);
        }

        $edu = StudentEducation::find($request->id);
        if($request->result_type == 'gpa'){
            $result = $request->result_gpa;
            $edu->out_of = $request->out_of;
        }elseif($request->result_type == 'division'){
            $result = $request->result_division;
        }else{
            $result = $request->result_pass;
        }
        //$result = $request->result_type == 'gpa' ?  $request->result_gpa : $request->result_division;
        $edu->edu_level_id = $request->edu_level_id;
        $edu->edu_group_id = $request->edu_group_id;
        $edu->edu_board_id = $request->edu_board_id;
        $edu->university = $request->university;
        $edu->passing_year = $request->passing_year;
        $edu->result_type = $request->result_type;
        $edu->result = $result;
        $edu->save();
        
        $education = StudentEducation::find($edu->id);
        $education->exam_name = $education->exam? $education->exam->name : '';
        $education->board_name = $education->board? $education->board->name : $education->university;
        $education->group_name = $education->group? $education->group->name : '';  

        return response()->json(['status' => true, 'type'=> 'update', 'education'=> $education, 'message' => 'Education updated successfully']);
    }

    public function destroy(Request $request)
    {
        $education = StudentEducation::find($request->id);
        $education->delete();
        return response()->json(['status' => true, 'type'=> 'delete', 'message' => 'Education deleted successfully']);
    }
}
