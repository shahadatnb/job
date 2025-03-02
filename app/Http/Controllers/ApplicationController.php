<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Category;
use App\Models\Location;
class ApplicationController extends Controller
{
    public function index()
    {        
        $applications = Service::where('created_by', auth('citizen')->user()->id)->latest()->paginate(10);
        return view('frontend.application.index', compact('applications'));
    }

    public function create(Request $request)
    {
        $cat_check = Category::where('name', $request->type)->first();
        if(!$cat_check){
            return redirect()->back()->with('error', 'Category not found');
        }
        $user = auth('citizen')->user();
        $districts = Location::whereNull('parent_id')->pluck('name', 'id');
        if($user->district_id){
            $upazilas = Location::where('parent_id', $user->district_id)->pluck('name', 'id');
        }else{
            $upazilas = [];
        }
        return view('frontend.application.create', compact('user', 'districts', 'upazilas'));
    }
    
}
