<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Setting;
use App\Models\Menu;
use App\Models\MenuItem;

class AdminController extends Controller
{
    
    public function index()
    {      
        return view('admin.pages.dashboard');
    }

    public function home(){
         return redirect()->route('dashboard');
     }

    public function settings()
    {
        $settings = Setting::where('status',1)->orderBy('sl','ASC')->get();
        return view('admin.pages.settings',compact('settings'));
    }

    public function saveSetting(Request $request, $id)
    {
        $data = Setting::findOrFail($id);
        if(isset($request->image)){
            $request->validate([
                'value' => 'required|mimes:jpg,jpeg,png|max:2048',
            ]);

            if (file_exists( public_path('upload\\site_file\\') . $data->value)) {
                unlink(public_path('upload\\site_file\\') . $data->value);
            }
      
            $fileName = time().'.'.$request->value->extension();  
            $upload_path = public_path('upload/site_file');
            $request->value->move($upload_path, $fileName);
            $data->value = $fileName;
            $data->save();
        }else{
            $data->value = $request->value ?? 0;
            $data->save();
        }
        \Artisan::call('config:cache');

        session()->flash('success','Setting Seved');
        return redirect()->back();
    }

    
    public function siteCache(){
        $munus = Menu::where('branch_id', session('branch')['id'])->get();
        foreach($munus as $m){
            $settings[$m->menu_id] = MenuItem::with('subMenu')->withCount('subMenu')->where('menu_id',$m->id)->where('parent_id',null)->orderBy('sl')->orderBy('sl','ASC')->get()->toArray();
        }
        
        //$branch = Branch::where('id', session('branch')['id'])->first()->toArray( );
        Cache::put(session('branch')['subdomain'], ['menus'=>$settings]);
        session()->flash('success', "Saved.");
        return redirect()->back();
    }
}
