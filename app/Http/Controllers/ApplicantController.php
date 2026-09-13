<?php

namespace App\Http\Controllers;

use App\Models\EduLevel;
use App\Models\Applicant;
use App\Models\Location;
use App\Models\JobApplication;
use App\Models\ApplicantEducation;
use App\Models\ApplicantEmployment;
use App\Models\ApplicantCertification;
use App\Models\ApplicantTraining;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
//use Image;
use Intervention\Image\Laravel\Facades\Image;
//use Storage;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\RateLimiter;
use App\Facades\CustomHelperFacade as CustomHelper;
use App\Exports\ApplicantsExport;
use Maatwebsite\Excel\Facades\Excel;

class ApplicantController extends Controller
{

    public function index()
    {
        $applicant = auth('applicant')->user();
        $job_info = session()->has('job_info') ? session()->get('job_info') : [];
        $districts = Location::whereNull('parent_id')->pluck('name', 'id');
        if($applicant->district_id){
            $upazilas = Location::where('parent_id', $applicant->district_id)->pluck('name', 'id');
        }else{
            $upazilas = [];
        }
        if($applicant->permanent_district_id){
            $permanent_upazilas = Location::where('parent_id', $applicant->permanent_district_id)->pluck('name', 'id');
        }else{
            $permanent_upazilas = [];
        }
        $exams = EduLevel::where('is_active', 1)->orderBy('serial', 'asc')->get();//->pluck('name', 'id');
        return view('frontend.pages.dashboard', compact('applicant', 'job_info', 'districts', 'upazilas', 'permanent_upazilas', 'exams'));
    }

    public function applicants(Request $request){
        $data = [];
        $query = Applicant::query();

        if ($request->filled('email')) {
            $query->where('email', 'like', '%'.$request->email.'%');
        }

        if ($request->filled('phone')) {
            $query->where('phone', 'like', '%'.$request->phone.'%');
        }

        $applicants = $query->latest('id')->paginate(50)->withQueryString();

        return view('admin.applicants.index', compact('applicants', 'data'));
    }

    public function export(Request $request)
    {
        $filename = 'applicants-'.now()->format('d-m-Y-His').'.xlsx';

        return Excel::download(new ApplicantsExport($request->only(['email', 'phone'])), $filename);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function profile()
    {
        $user = auth('applicant')->user();
        return view('frontend.pages.profile', compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function view_cv()
    {
        $applicant = auth('applicant')->user();
        return view('frontend.pages.cv', compact('applicant'));
    }

    public function show(Applicant $applicant)
    {
        return view('admin.applicants.show', compact('applicant'));
    }

    public function edit(Applicant $applicant)
    {
        $districts = Location::whereNull('parent_id')->pluck('name', 'id');
        $upazilas = $applicant->district_id ? Location::where('parent_id', $applicant->district_id)->pluck('name', 'id') : [];
        $permanentUpazilas = $applicant->permanent_district_id ? Location::where('parent_id', $applicant->permanent_district_id)->pluck('name', 'id') : [];

        return view('admin.applicants.createOrEdit', compact('applicant', 'districts', 'upazilas', 'permanentUpazilas'));
    }

    public function update(Request $request, Applicant $applicant)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50',
            'email' => 'required|email|unique:applicants,email,' . $applicant->id,
            'phone' => 'required|digits:11|unique:applicants,phone,' . $applicant->id,
            'nid' => 'nullable|max:17|unique:applicants,nid,' . $applicant->id,
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|in:Male,Female',
            'religion' => 'nullable|string|max:30',
            'blood_group' => 'nullable|string|max:10',
            'father_name' => 'nullable|string|max:50',
            'mother_name' => 'nullable|string|max:50',
            'village' => 'nullable|string|max:50',
            'post_office' => 'nullable|string|max:50',
            'post_code' => 'nullable|numeric',
            'district_id' => 'nullable|exists:locations,id',
            'upazila_id' => 'nullable|exists:locations,id',
            'permanent_village' => 'nullable|string|max:50',
            'permanent_post_office' => 'nullable|string|max:50',
            'permanent_post_code' => 'nullable|numeric',
            'permanent_district_id' => 'nullable|exists:locations,id',
            'permanent_upazila_id' => 'nullable|exists:locations,id',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:200',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $applicant->name = $request->name;
        $applicant->email = $request->email;
        $applicant->phone = $request->phone;
        $applicant->nid = $request->nid;
        if ($request->filled('date_of_birth')) {
            $applicant->date_of_birth = Carbon::parse($request->date_of_birth)->format('Y-m-d');
        }
        $applicant->gender = $request->gender;
        $applicant->religion = $request->religion;
        $applicant->blood_group = $request->blood_group;
        $applicant->father_name = $request->father_name;
        $applicant->mother_name = $request->mother_name;

        $applicant->village = $request->village;
        $applicant->post_office = $request->post_office;
        $applicant->post_code = $request->post_code;
        $applicant->district_id = $request->district_id;
        $applicant->upazila_id = $request->upazila_id;
        $applicant->permanent_village = $request->permanent_village;
        $applicant->permanent_post_office = $request->permanent_post_office;
        $applicant->permanent_post_code = $request->permanent_post_code;
        $applicant->permanent_district_id = $request->permanent_district_id;
        $applicant->permanent_upazila_id = $request->permanent_upazila_id;

        if ($request->hasFile('photo')) {
            $oldPhoto = $applicant->photo;
            $imgFile = Image::read($request->file('photo'))->resize(300, 300, function ($constraint) {
                $constraint->aspectRatio();
            })->toJpeg(80);
            $fileName = 'applicant/photo/' . time() . '.jpg';
            Storage::disk('public')->put($fileName, $imgFile);
            $applicant->photo = $fileName;
            if ($oldPhoto && Storage::disk('public')->exists($oldPhoto)) {
                Storage::disk('public')->delete($oldPhoto);
            }
        }

        $applicant->save();

        return redirect()->route('applicant.show', $applicant)->with('success', 'Applicant updated successfully');
    }

    public function editProfile()
    {
        $user = auth('applicant')->user();
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
            'email' => 'required|email|unique:applicants,email,' . auth('applicant')->user()->id,
            'phone' => 'required|digits:11|unique:applicants,phone,' . auth('applicant')->user()->id,
            'nid' => 'required|max:17|unique:applicants,nid,' . auth('applicant')->user()->id,
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

        $applicant = auth('applicant')->user();
        $applicant->name = $request->name;
        $applicant->email = $request->email;
        $applicant->phone = $request->phone;
        $applicant->nid = $request->nid;
        $applicant->date_of_birth = Carbon::parse($request->date_of_birth)->format('Y-m-d'); // $request->date_of_birth;
        $applicant->gender = $request->gender;
        $applicant->religion = $request->religion;
        $applicant->blood_group = $request->blood_group;
        $applicant->father_name = $request->father_name;
        $applicant->mother_name = $request->mother_name;

        $applicant->village = $request->village;
        $applicant->post_office = $request->post_office;
        $applicant->post_code = $request->post_code;
        $applicant->district_id = $request->district_id;
        $applicant->upazila_id = $request->upazila_id;
        $applicant->permanent_village = $request->permanent_village;
        $applicant->permanent_post_office = $request->permanent_post_office;
        $applicant->permanent_post_code = $request->permanent_post_code;
        $applicant->permanent_district_id = $request->permanent_district_id;
        $applicant->permanent_upazila_id = $request->permanent_upazila_id;
        $applicant->save();
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

        $applicant = auth('applicant')->user();
        $applicant->objective = $request->objective;
        $applicant->present_salary = $request->present_salary;
        $applicant->expected_salary = $request->expected_salary;
        $applicant->looking_for = $request->looking_for;
        $applicant->available_for = $request->available_for;
        $applicant->save();
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

        $applicant = auth('applicant')->user();
        $applicant->career_summary = $request->career_summary;
        $applicant->special_qualification = $request->special_qualification;
        $applicant->keywords = $request->keywords;
        $applicant->save();
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

        $applicant = auth('applicant')->user();
        $image = $request->file('photo');
        if ($image) {
            Storage::delete('public/photo/'.$applicant->photo);
            $imgFile  = Image::read($request->photo)->resize(300, 300, function ($constraint) {
                $constraint->aspectRatio();
            })->toJpeg(80);
            $file_name = 'applicant/photo/'.time() .'.jpg';
            Storage::disk('public')->put($file_name, $imgFile);
            $applicant->photo = $file_name;
        }
        $applicant->save();
        return response()->json(['status' => true, 'photo' => asset('storage/'.$applicant->photo)]);
    }

    public function updateSignature(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'signature' => 'required|image|mimes:jpeg,png,jpg|max:40',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()]);
        }

        $applicant = auth('applicant')->user();
        $image = $request->file('signature');
        if ($image) {
            Storage::delete('public/signature/'.$applicant->signature);
            $imgFile  = Image::read($request->signature)->resize(300, 80, function ($constraint) {
                $constraint->aspectRatio();
            })->toJpeg(80);
            $file_name = 'applicant/signature/'.time() .'.jpg';
            Storage::disk('public')->put($file_name, $imgFile);
            $applicant->signature = $file_name;
        }
        $applicant->save();
        return response()->json(['status' => true, 'signature' => asset('storage/'.$applicant->signature)]);
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

        $user = Applicant::find(auth('applicant')->user()->id);
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
        return response()->json(['status' => true, 'type'=> 'save', 'applicant'=> $user, 'message' => 'saved successfully']);

        //session()->flash('success', 'Profile updated successfully');
        //return redirect()->route('applicant.profile');
    }

    public function applied_jobs()
    {
        $applied_jobs = JobApplication::where('applicant_id', auth('applicant')->user()->id)->with('job')->latest()->get();
        return view('frontend.pages.applied_jobs', compact('applied_jobs'));
    }

    public function destroy(Applicant $applicant)
    {
        if ($applicant->applications()->exists()) {
            return redirect()->back()->with('warning', 'This applicant has job applications and cannot be deleted.');
        }

        if ($applicant->photo && Storage::disk('public')->exists($applicant->photo)) {
            Storage::disk('public')->delete($applicant->photo);
        }

        $applicant->delete();

        return redirect()->route('applicant.index')->with('success', 'Applicant deleted successfully');
    }

    public function send_otp(Request $request) {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|digits:11|exists:applicants,phone',
        ],
        [
            'phone.exists' => 'Phone number does not exist.',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()->all()]);
        }

        $applicant = Applicant::where('phone', $request->phone)->first();

        $ipKey = 'otp-send-ip:'.$request->ip();
        if (RateLimiter::tooManyAttempts($ipKey, 5)) {
            return response()->json(['status' => false, 'message' => 'Too many requests. Please try again later.'], 429);
        }
        RateLimiter::hit($ipKey, 3600);

        $sentKey = 'otp:'.$applicant->id.'.sent';
        if (Cache::has($sentKey)) {
            return response()->json(['status' => false, 'message' => 'OTP has been sent already. Please wait for 3 minutes.']);
        }

        $otp = (string) random_int(100000, 999999);
        Cache::put('otp:'.$applicant->id, Hash::make($otp), now()->addMinutes(10));
        Cache::put($sentKey, true, now()->addMinutes(3));
        Cache::forget('otp:'.$applicant->id.'.attempts');

        $message = 'Your OTP is: '.$otp.'. Do not share with anyone. - '.config('app.name');
        $contact = substr($applicant->phone, 0, 2) == '88' ? $applicant->phone : '88'.$applicant->phone;
        CustomHelper::send_sms($contact, $message);

        return response()->json(['status' => true, 'message' => 'OTP has been sent successfully.']);
    }

    public function password_save(Request $request) {
        $validator = Validator::make($request->all(), [
            'password' => 'required|string|min:8|max:255|confirmed',
            'phone_number' => ['required', 'digits:11', 'exists:applicants,phone'],
            'otp' => 'required|digits:6',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()->all()]);
        }

        $applicant = Applicant::where('phone', $request->phone_number)->firstOrFail();

        $otpKey = 'otp:'.$applicant->id;
        $storedHash = Cache::get($otpKey);

        if (!$storedHash) {
            return response()->json(['status' => false, 'message' => 'Invalid or expired OTP. Please request a new one.']);
        }

        $attemptsKey = $otpKey.'.attempts';
        if (RateLimiter::tooManyAttempts($attemptsKey, 5)) {
            Cache::forget($otpKey);
            return response()->json(['status' => false, 'message' => 'Too many invalid attempts. Please request a new OTP.'], 429);
        }

        if (!Hash::check($request->otp, $storedHash)) {
            RateLimiter::hit($attemptsKey, 600);
            return response()->json(['status' => false, 'message' => 'Invalid OTP. Attempts remaining: '.RateLimiter::remaining($attemptsKey, 5)]);
        }

        RateLimiter::clear($attemptsKey);
        Cache::forget($otpKey);
        Cache::forget($otpKey.'.sent');

        $applicant->password = Hash::make($request->password);
        $applicant->otp = null;
        $applicant->save();
        return response()->json(['status' => true, 'message' => 'Password has been updated successfully.']);
    }
}
