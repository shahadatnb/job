<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Job;

class HomeController extends Controller
{
    public function homepage(){
        $jobs = Job::where('status', 1)->whereDate('last_date', '>', date('Y-m-d'))->latest()->paginate(50);
        return view('frontend.pages.index',compact('jobs'));
        //return redirect()->route('login');
    }

   public function page(Request $request, $slug){
        $page = Post::where('slug', $slug)->first();
        if($page){            
            return view('frontend.pages.single',compact('page'));
        }
        abort(404);
   }

   public function section(Request $request, $post_type){
        //dd($request->all(), $post_type);
        $datas = Post::where('post_type','post_type')->latest()->get();
        return view('frontend.pages.admission_result',compact('datas'));
   }

}
