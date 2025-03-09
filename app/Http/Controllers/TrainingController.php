<?php

namespace App\Http\Controllers;

use App\Models\StudentTraining;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TrainingController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'training_title' => 'required',
            'topics_covered' => 'required',
            'training_year' => 'required',
            'training_institute' => 'required',
            'training_duration' => 'required',
            'training_location' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()->all()]);
        }

        $training = new StudentTraining();
        $training->student_id = auth('student')->user()->id;
        $training->training_title = $request->training_title;
        $training->topics_covered = $request->topics_covered;
        $training->training_year = $request->training_year;
        $training->training_institute = $request->training_institute;
        $training->training_duration = $request->training_duration;
        $training->training_location = $request->training_location;
        $training->save();
        return response()->json(['status' => true, 'type'=> 'save', 'training'=> $training, 'message' => 'Training saved successfully']);
    }

    public function edit(Request $request)
    {
        $training = StudentTraining::find($request->id);
        return response()->json(['status' => true, 'type'=> 'edit', 'training'=> $training]);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'training_title' => 'required',
            'topics_covered' => 'required',
            'training_year' => 'required',
            'training_institute' => 'required',
            'training_duration' => 'required',
            'training_location' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()->all()]);
        }
        $training = StudentTraining::find($request->id);
        $training->training_title = $request->training_title;
        $training->topics_covered = $request->topics_covered;
        $training->training_year = $request->training_year;
        $training->training_institute = $request->training_institute;
        $training->training_duration = $request->training_duration;
        $training->training_location = $request->training_location;
        $training->save();
        return response()->json(['status' => true, 'type'=> 'update', 'training'=> $training, 'message' => 'Training updated successfully']);
    }

    public function destroy(Request $request)
    {
        $training = StudentTraining::find($request->id);
        $training->delete();
        return response()->json(['status' => true, 'type'=> 'delete', 'message' => 'Training deleted successfully']);
    }
}
