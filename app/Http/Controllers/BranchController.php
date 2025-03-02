<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\User;
use App\Models\Location;
use Illuminate\Http\Request;

class BranchController extends Controller
{

    public function index()
    {
        $branches = Branch::all();
        return view('admin.branch.index',compact('branches'));
    }

    public function create()
    {
        $zilas = Location::where('parent_id', null)->pluck('name','id');
        $upaZilas = [];
        return view('admin.branch.edit', compact('zilas','upaZilas'));
    }


    public function store(Request $request)
    {
        $this->validate(request(),[
            'name' => 'required',
            'address' => 'required',
            'contact' => 'nullable',
            'login_email' => 'required|email',
            'password' => 'required|string|min:6',
            'email' => 'nullable|email',
            'chairman_name' => 'nullable|string|max:150',
            'chairman_email' => 'nullable|email',
            'chairman_contact' => 'nullable',
            'chairman_designation' => 'nullable|string|max:150',
            'exp_date' => 'nullable|date',
        ]);

        $branch = new Branch;
        $branch->name = $request->name;
        $branch->website = $request->website;
        $branch->address = $request->address;
        $branch->zila_id = $request->zila_id;
        $branch->upazila_id = $request->upazila_id;
        $branch->contact = $request->contact;
        $branch->email = $request->email;
        $branch->chairman_name = $request->chairman_name;
        $branch->chairman_email = $request->chairman_email;
        $branch->chairman_contact = $request->chairman_contact;
        $branch->chairman_designation = $request->chairman_designation;
        $branch->exp_date = $request->exp_date;
        $branch->save();

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->login_email;
        $user->password = bcrypt($request->password);
        $user->save();

        $user->branches()->sync($branch->id);

        session()->flash('success','Successfully Save');
        return redirect()->route('branch.index');
    }


    public function show(Branch $branch)
    {
        //
    }


    public function edit(Branch $branch)
    {
        $zilas = Location::where('parent_id', null)->pluck('name','id');
        $upaZilas = [];
        if($branch->zila_id != ''){
            $upaZilas = Location::where('parent_id', $branch->zila_id)->pluck('name','id');
        }
        return view('admin.branch.edit',compact('branch','zilas','upaZilas'));
    }


    public function update(Request $request, Branch $branch)
    {
        $this->validate(request(),[
            'name' => 'required',
            'address' => 'required',
            'contact' => 'nullable',
            'email' => 'nullable|email',
            'chairman' => 'nullable|string|max:150',
            'chairman_email' => 'nullable|email',
            'chairman_contact' => 'nullable',
            'chairman_designation' => 'nullable|string|max:150',
            'chairman_sign' => 'nullable|mimes:jpg,jpeg,png|max:100',
            'exp_date' => 'nullable|date',
        ]);

        $branch->name = $request->name;
        $branch->website = $request->website;
        $branch->address = $request->address;
        $branch->zila_id = $request->zila_id;
        $branch->upazila_id = $request->upazila_id;
        $branch->contact = $request->contact;
        $branch->email = $request->email;
        $branch->chairman_name = $request->chairman_name;
        $branch->chairman_email = $request->chairman_email;
        $branch->chairman_contact = $request->chairman_contact;
        $branch->chairman_designation = $request->chairman_designation;        

        if(isset($request->chairman_sign)){
            if ($branch->chairman_sign != '' && file_exists( public_path('upload\\site_file\\') . $branch->chairman_sign)) {
                unlink(public_path('upload\\site_file\\') . $branch->chairman_sign);
            }
      
            $fileName = time().'.'.$request->chairman_sign->extension();  
            $upload_path = public_path('upload/site_file');
            $request->chairman_sign->move($upload_path, $fileName);
            $branch->chairman_sign = $fileName;
        }
        
        $branch->exp_date = $request->exp_date;
        $branch->status = $request->status ? 1 : 0;

        $branch->save();

        session()->flash('success','Successfully Save');
        return redirect()->route('branch.index');
    }

    public function destroy(Branch $branch)
    {
        //
    }
}
