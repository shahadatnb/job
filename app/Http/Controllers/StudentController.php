<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Location;
use Illuminate\Http\Request;

class StudentController extends Controller
{

    public function index()
    {
        $user = auth('student')->user();
        $districts = Location::whereNull('parent_id')->pluck('name', 'id');
        if($user->district_id){
            $upazilas = Location::where('parent_id', $user->district_id)->pluck('name', 'id');
        }else{
            $upazilas = [];
        }
        return view('frontend.pages.dashboard', compact('user', 'districts', 'upazilas'));
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
    public function store(Request $request)
    {
        //
    }

    public function show(Student $student)
    {
        //
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
        return view('frontend.pages.profile_edit', compact('user', 'districts', 'upazilas'));
    }

    public function updateProfile(Request $request)
    {
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

        ]);        

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
        $user->village = $request->village;
        $user->post_office = $request->post_office;
        $user->post_code = $request->post_code;
        $user->district_id = $request->district_id;
        $user->upazila_id = $request->upazila_id;
        $user->parmanent_village = $request->parmanent_village;
        $user->parmanent_post_office = $request->parmanent_post_office;
        $user->parmanent_post_code = $request->parmanent_post_code;
        $user->parmanent_district_id = $request->parmanent_district_id;
        $user->parmanent_upazila_id = $request->parmanent_upazila_id;
        $user->save();
        session()->flash('success', 'Profile updated successfully');
        return redirect()->route('student.profile');
    }

    public function destroy(Student $student)
    {
        //
    }
}
