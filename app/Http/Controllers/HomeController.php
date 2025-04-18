<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Job;

class HomeController extends Controller
{
    public function homepage(){
        $jobs = Job::where('status', 1)->latest()->paginate(50);
        return view('frontend.pages.index',compact('jobs'));
        //return redirect()->route('login');
    }

   public function page(Request $request, $branch, $page){
        $page = Post::where('slug', $page)->where('branch_id', $request->branch->id)->first();
        if($page){            
            return view('frontend.pages.single',compact('page'));
        }
        abort(404);
   }

   public function section(Request $request, $branch, $post_type){
        //dd($request->all(), $post_type);
        $datas = Post::where('post_type','post_type')->where('branch_id', $request->branch->id)->latest()->get();
        return view('frontend.pages.admission_result',compact('datas'));
   }

}
