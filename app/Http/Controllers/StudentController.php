<?php

namespace App\Http\Controllers;

use App\Models\EduLevel;
use App\Models\Student;
use App\Models\Location;
use App\Models\StudentEducation;
use App\Models\StudentEmployment;
use App\Models\StudentCertification;
use App\Models\StudentTraining;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
//use Image;
use Intervention\Image\Laravel\Facades\Image;
//use Storage;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{

    public function index()
    {
        $student = auth('student')->user();
        $districts = Location::whereNull('parent_id')->pluck('name', 'id');
        if($student->district_id){
            $upazilas = Location::where('parent_id', $student->district_id)->pluck('name', 'id');
        }else{
            $upazilas = [];
        }
        if($student->permanent_district_id){
            $permanent_upazilas = Location::where('parent_id', $student->permanent_district_id)->pluck('name', 'id');
        }else{
            $permanent_upazilas = [];
        }
        $exams = EduLevel::where('is_active', 1)->get();//->pluck('name', 'id');
        return view('frontend.pages.dashboard', compact('student', 'districts', 'upazilas', 'permanent_upazilas', 'exams'));
    }

    public function students(){
        $data = [];
        $students = Student::paginate(50);
        return view('admin.students.index', compact('students', 'data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function profile()
    {
        $user = auth('student')->user();
        return view('frontend.pages.profile', compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function view_cv()
    {
        $student = auth('student')->user();
        return view('frontend.pages.cv', compact('student'));
    }

    public function show(Student $student)
    {
        return view('frontend.pages.cv', compact('student'));
    }

    public function editProfile()
    {
        $user = auth('student')->user();
        $districts = Location::whereNull('parent_id')->pluck('name', 'id');
        if($user->district_id){
            $upazilas = Location::where('parent_id', $user->district_id)->pluck('name', 'id');
        }else{
            $upazilas = [];
        }
        if($user->permanent_district_id){
            $permanent_upazilas = Location::where('parent_id', $user->permanent_district_id)->pluck('name', 'id');
        }else{
            $permanent_upazilas = [];
        }
        return view('frontend.pages.profile_edit', compact('user', 'districts', 'upazilas', 'permanent_upazilas'));
    }

    public function updateAddress(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'village' => 'required|string|max:50',
            'post_office' => 'required|string|max:50',
            'post_code' => 'nullable|numeric',
            'district_id' => 'required',
            'upazila_id' => 'required',
            'permanent_village' => 'required|string|max:50',
            'permanent_post_office' => 'required|string|max:50',
            'permanent_post_code' => 'nullable|numeric',
            'permanent_district_id' => 'required',
            'permanent_upazila_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()]);
        }

        $student = auth('student')->user();
        $student->village = $request->village;
        $student->post_office = $request->post_office;
        $student->post_code = $request->post_code;
        $student->district_id = $request->district_id;
        $student->upazila_id = $request->upazila_id;
        $student->permanent_village = $request->permanent_village;
        $student->permanent_post_office = $request->permanent_post_office;
        $student->permanent_post_code = $request->permanent_post_code;
        $student->permanent_district_id = $request->permanent_district_id;
        $student->permanent_upazila_id = $request->permanent_upazila_id;
        $student->save();
        return response()->json(['status' => true,'message' => 'Address updated successfully']);
    }

    public function updatePhoto(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'photo' => 'required|image|mimes:jpeg,png,jpg',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()]);
        }

        $student = auth('student')->user();
        $image = $request->file('photo');
        if ($image) {
            Storage::delete('public/'.$student->photo);
            $imgFile  = Image::read($request->photo)->resize(300, 300, function ($constraint) {
                $constraint->aspectRatio();
            })->toJpeg(80);
            $file_name = 'ex_student/'.time() .'.jpg';
            Storage::disk('public')->put($file_name, $imgFile);
            $student->photo = $file_name;
        }
        $student->save();
        return response()->json(['status' => true, 'photo' => asset('storage/'.$student->photo)]);
    }

    public function updateProfile(Request $request)
    {
        /*
        $request->validate([
            'name' => 'required|string|max:50',
            'email' => 'required|email',
            'phone' => 'required|digits:11',
            'nid' => 'required|max:17',
            'date_of_birth' => 'required',
            'father_name' => 'required|string|max:50',
            'mother_name' => 'required|string|max:50',
            'village' => 'required|string|max:50',
            'ward' => 'required|numeric',
            'post_office' => 'required|string|max:50',
            'post_code' => 'required|numeric',

            'village' => 'required|string|max:50',
            'ward' => 'required|numeric',
            'post_office' => 'required|string|max:50',
            'post_code' => 'required|numeric',
            'district_id' => 'required',
            'upazila_id' => 'required',
            'permanent_village' => 'required|string|max:50',
            'permanent_ward' => 'required|numeric',
            'permanent_post_office' => 'required|string|max:50',
            'permanent_post_code' => 'required|numeric',
            'permanent_district_id' => 'required',
            'permanent_upazila_id' => 'required',
        ]);
        */
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50',
            'email' => 'required|email',
            'phone' => 'required|digits:11',
            'nid' => 'required|max:17',
            'date_of_birth' => 'required',
            'father_name' => 'required|string|max:50',
            'mother_name' => 'required|string|max:50',            
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()->all()]);
        }

        $user = Student::find(auth('student')->user()->id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->nid = $request->nid;
        $user->date_of_birth = $request->date_of_birth;
        $user->gender = $request->gender;
        $user->religion = $request->religion;
        $user->blood_group = $request->blood_group;
        $user->father_name = $request->father_name;
        $user->mother_name = $request->mother_name;
        /*
        $user->village = $request->village;
        $user->post_office = $request->post_office;
        $user->post_code = $request->post_code;
        $user->district_id = $request->district_id;
        $user->upazila_id = $request->upazila_id;
        $user->permanent_village = $request->permanent_village;
        $user->permanent_post_office = $request->permanent_post_office;
        $user->permanent_post_code = $request->permanent_post_code;
        $user->permanent_district_id = $request->permanent_district_id;
        $user->permanent_upazila_id = $request->permanent_upazila_id;
        */
        $user->save();
        return response()->json(['status' => true, 'type'=> 'save', 'student'=> $user, 'message' => 'Education saved successfully']);

        //session()->flash('success', 'Profile updated successfully');
        //return redirect()->route('student.profile');
    }

    

    public function destroy(Student $student)
    {
        //
    }
}
