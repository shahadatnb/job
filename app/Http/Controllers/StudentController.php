<?php

namespace App\Http\Controllers;

use App\Models\EduLevel;
use App\Models\Student;
use App\Models\Location;
use App\Models\JobApplication;
use App\Models\StudentEducation;
use App\Models\StudentEmployment;
use App\Models\StudentCertification;
use App\Models\StudentTraining;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
//use Image;
use Intervention\Image\Laravel\Facades\Image;
//use Storage;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use App\Facades\CustomHelperFacade as CustomHelper;

class StudentController extends Controller
{

    public function index()
    {
        $student = auth('student')->user();
        $job_info = session()->has('job_info') ? session()->get('job_info') : [];
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
        $exams = EduLevel::where('is_active', 1)->orderBy('serial', 'asc')->get();//->pluck('name', 'id');
        return view('frontend.pages.dashboard', compact('student', 'job_info', 'districts', 'upazilas', 'permanent_upazilas', 'exams'));
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
        return view('admin.students.show', compact('student'));
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
            'name' => 'required|string|max:50',
            'father_name' => 'required|string|max:50',
            'mother_name' => 'required|string|max:50',
            'email' => 'required|email|unique:students,email,' . auth('student')->user()->id,
            'phone' => 'required|digits:11|unique:students,phone,' . auth('student')->user()->id,
            'nid' => 'required|max:17|unique:students,nid,' . auth('student')->user()->id,
            'date_of_birth' => 'required',
            'gender' => 'required',
            'religion' => 'required',
            'blood_group' => 'required',
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
            return response()->json(['status' => false, 'errors' => $validator->errors()->all()]);
        }

        $student = auth('student')->user();
        $student->name = $request->name;
        $student->email = $request->email;
        $student->phone = $request->phone;
        $student->nid = $request->nid;
        $student->date_of_birth = Carbon::parse($request->date_of_birth)->format('Y-m-d'); // $request->date_of_birth;
        $student->gender = $request->gender;
        $student->religion = $request->religion;
        $student->blood_group = $request->blood_group;
        $student->father_name = $request->father_name;
        $student->mother_name = $request->mother_name;

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

    public function updateCareer(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'objective' => 'required|string|max:800',
            'present_salary' => 'nullable|numeric|max:999999',
            'expected_salary' => 'nullable|numeric|max:999999',
            'looking_for' => 'nullable|string|max:50',
            'available_for' => 'nullable|string|max:50',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()->all()]);
        }

        $student = auth('student')->user();
        $student->objective = $request->objective;
        $student->present_salary = $request->present_salary;
        $student->expected_salary = $request->expected_salary;
        $student->looking_for = $request->looking_for;
        $student->available_for = $request->available_for;
        $student->save();
        return response()->json(['status' => true,'message' => 'Career and Application Information updated successfully']);
    }

    public function updateOther(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'career_summary' => 'required|string|max:800',
            'special_qualification' => 'required|string|max:800',
            'keywords' => 'required|string|max:250',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()->all()]);
        }

        $student = auth('student')->user();
        $student->career_summary = $request->career_summary;
        $student->special_qualification = $request->special_qualification;
        $student->keywords = $request->keywords;
        $student->save();
        return response()->json(['status' => true,'message' => 'Other Relevant Information updated successfully']);
    }

    public function updatePhoto(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'photo' => 'required|image|mimes:jpeg,png,jpg|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()]);
        }

        $student = auth('student')->user();
        $image = $request->file('photo');
        if ($image) {
            Storage::delete('public/photo/'.$student->photo);
            $imgFile  = Image::read($request->photo)->resize(300, 300, function ($constraint) {
                $constraint->aspectRatio();
            })->toJpeg(80);
            $file_name = 'student/photo/'.time() .'.jpg';
            Storage::disk('public')->put($file_name, $imgFile);
            $student->photo = $file_name;
        }
        $student->save();
        return response()->json(['status' => true, 'photo' => asset('storage/'.$student->photo)]);
    }

    public function updateSignature(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'signature' => 'required|image|mimes:jpeg,png,jpg|max:40',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()]);
        }

        $student = auth('student')->user();
        $image = $request->file('signature');
        if ($image) {
            Storage::delete('public/signature/'.$student->signature);
            $imgFile  = Image::read($request->signature)->resize(300, 80, function ($constraint) {
                $constraint->aspectRatio();
            })->toJpeg(80);
            $file_name = 'student/signature/'.time() .'.jpg';
            Storage::disk('public')->put($file_name, $imgFile);
            $student->signature = $file_name;
        }
        $student->save();
        return response()->json(['status' => true, 'signature' => asset('storage/'.$student->signature)]);
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
        $user->date_of_birth = Carbon::parse($request->date_of_birth)->format('Y-m-d'); // $request->date_of_birth;
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
        return response()->json(['status' => true, 'type'=> 'save', 'student'=> $user, 'message' => 'saved successfully']);

        //session()->flash('success', 'Profile updated successfully');
        //return redirect()->route('student.profile');
    }

    public function applied_jobs()
    {
        $applied_jobs = JobApplication::where('student_id', auth('student')->user()->id)->with('job')->latest()->get();
        return view('frontend.pages.applied_jobs', compact('applied_jobs'));
    }

    public function destroy(Student $student)
    {
        //
    }

    public function send_otp(Request $request) {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|exists:students,phone',
        ],
        [
            'phone.exists' => 'Phone number does not exist.',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()->all()]);
        }

        $student = Student::where('phone', $request->phone)->first();

        if(isset($_COOKIE['otp']) && $_COOKIE['otp'] == $student->id)
        { 
            return response()->json(['status' => false, 'message' => 'OTP has been sent already. Please wait for 3 minutes.']);
        }

        $otp = rand(1000, 9999);
        $student->otp = $otp;
        $student->save();

        $message = 'Your OTP is: '.$otp.'. Do not share with anyone. - '.config('app.name');
        $contact = substr($student->phone, 0, 2) == '88' ? $student->phone : '88'.$student->phone;
        $responsed=    CustomHelper::send_sms($contact, $message);
        //dd($responsed);
        setcookie('otp', $student->id, time() + (60 * 3), "/");
        return response()->json(['status' => true, 'message' => 'OTP has been sent successfully.']);
    }

    public function password_save(Request $request) {
        $validator = Validator::make($request->all(), [
            'password' => 'required|string|min:6|max:15|confirmed',
            'phone_number' => 'required',
            'otp' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()->all()]);
        }

        $student = Student::where('otp', $request->otp)->where('phone',$request->phone_number)->first();

        if(!isset($student)) {
            return response()->json(['status' => false, 'message' => 'Invalid OTP.']);
        }

        $student->password = Hash::make($request->password);
        $student->otp = null;
        $student->save();
        return response()->json(['status' => true, 'message' => 'Password has been updated successfully.']);
    }
}
