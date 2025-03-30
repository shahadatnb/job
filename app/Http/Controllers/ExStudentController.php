<?php

namespace App\Http\Controllers;

use App\Models\ExStudent;
use App\Models\EduGroup;
use Illuminate\Http\Request;
//use Image;
use Intervention\Image\Laravel\Facades\Image;
//use Storage;
use Illuminate\Support\Facades\Storage;

class ExStudentController extends Controller
{
    public function index(Request $request)
    {
        $data['department_id'] = '';
        $eduGroups = EduGroup::where('edu_level_id', 2)->pluck('name', 'id')->toArray();
        $exStudents = ExStudent::latest();
        if(!empty($request->department_id)){
            $data['department_id'] = $request->department_id;
            $exStudents = $exStudents->where('department_id', $request->department_id);
        }
        $exStudents = $exStudents->paginate(50);
        return view('admin.ex-students.index', compact('exStudents', 'eduGroups', 'data'));
    }


    public function create()
    {
        $eduGroups = EduGroup::where('edu_level_id', 2)->pluck('name', 'id')->toArray();
        return view('frontend.pages.ex-student', compact('eduGroups'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:ex_students',
            'mobile' => 'required|unique:ex_students|digits:11',
            'department_id' => 'required',
            'roll_number' => 'required',
            'registration_number' => 'required',
            'session' => 'required',
            'passing_year' => 'required|numeric|digits:4',
            'job_information' => 'required|string',
            'photo' => 'required|image|mimes:jpeg,png,jpg',
        ]);

        $exStudent = new ExStudent();
        $exStudent->name = $request->name;
        $exStudent->email = $request->email;
        $exStudent->mobile = $request->mobile;
        $exStudent->department_id = $request->department_id;
        $exStudent->roll_number = $request->roll_number;
        $exStudent->registration_number = $request->registration_number;
        $exStudent->session = $request->session;
        $exStudent->passing_year = $request->passing_year;
        $exStudent->job_information = $request->job_information;
        $image = $request->file('photo');
        if ($image) {
            //Storage::delete('public/'.$student->photo);
            $imgFile  = Image::read($request->photo)->resize(300, 300, function ($constraint) {
                $constraint->aspectRatio();
            })->toJpeg(80);
            $file_name = 'ex_student/'.time() .'.jpg';
            Storage::disk('public')->put($file_name, $imgFile);
            $exStudent->photo = $file_name;
        }
        $exStudent->save();
        session()->flash('success', 'Ex Student created successfully');
        return redirect()->back();
    }

    public function show(ExStudent $exStudent)
    {
        //
    }

    public function edit(ExStudent $exStudent)
    {
        $eduGroups = EduGroup::where('edu_level_id', 2)->pluck('name', 'id')->toArray();
        return view('admin.ex-students.edit', compact('exStudent', 'eduGroups'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ExStudent $exStudent)
    {
        //
    }

    public function destroy(ExStudent $exStudent)
    {
        $exStudent->delete();
        session()->flash('success', 'Ex Student deleted successfully');
        return redirect()->back();
    }
}
