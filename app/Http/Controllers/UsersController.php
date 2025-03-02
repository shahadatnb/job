<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\User;
use App\Models\Role;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use Illuminate\Support\Str;

class UsersController extends Controller
{

    public function index()
    {
        if(auth()->user()->hasRole('superadmin')){
            $users = User::orderBy('id', 'desc')->get();
        }else{
            $users = User::orderBy('id', 'desc')->whereHas('roles', function($q){$q->where('name', '!=', 'superadmin');})->get();
        }
        return view('admin.users.index', ['users' => $users]);
    }


    public function create(Request $request)
    {
        if($request->ajax()){
            $roles = Role::where('id', $request->role_id)->first();
            //return $request->role_id;
            $permissions = $roles->permissions;
            return $permissions;
        }

        $roles = Role::all();
        
        return view('admin.users.create', ['roles' => $roles]);
    }


    public function store(Request $request)
    {
        //validate the fields
        $request->validate([
            'name' => 'required|max:255',
            'username' => 'nullable|unique:users|max:25',
            'Designation' => 'required|max:255',
            'mobile' => 'required|max:255',
            'email' => 'required|unique:users|email|max:255',
            'password' => 'required|between:8,255|confirmed',
            'password_confirmation' => 'required'
        ]);

        $user = new User;
        $user->name = $request->name;
        $user->username = $request->username;
        $user->Designation = $request->Designation;
        $user->mobile = $request->mobile;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        if($request->role != null){
            $user->roles()->attach($request->role);
            $user->save();
        }
/*
        if($request->permissions != null){            
            foreach ($request->permissions as $permission) {
                $user->permissions()->attach($permission);
                $user->save();
            }
        }
*/
        return redirect()->route('users.index');
    }


    public function show(User $user)
    {
        $permissions = Permission::orderBy('id', 'desc')->pluck('name','id')->toArray();
        $branches = Branch::orderBy('id', 'desc')->pluck('name','id')->toArray();
        return view('admin.users.show', ['user'=>$user,'permissions'=>$permissions,'branches'=>$branches]);
    }

    public function assignPermission (Request $request, User $user){
        $user->permissions()->sync($request->permissions);
        session()->flash('success', "Permission assigned.");
        return redirect()->back();
    }

    public function assignBranch (Request $request, User $user){
        $user->branches()->sync($request->branches);
        session()->flash('success', "Branch assigned.");
        return redirect()->back();
    }


    public function edit(User $user)
    {
        $get_roles = Role::get();
        $roles = [];
        foreach ($get_roles as $role) {
            $roles[$role->id] = $role->name;
        }
//return $user->roles->first();
        $userRole = $user->roles;//->first();
        if($userRole != null){
            foreach ($userRole as $permission) {
                $rolePermissions[$permission->slug] = $permission->allRolePermissions;
            }
            //$rolePermissions = $userRole->allRolePermissions;
        }else{
            $rolePermissions = null;
        }
        $userPermissions = $user->permissions;

            //return $rolePermissions;
        // dd($rolePermission);

        return view('admin.users.edit', [
            'user'=>$user,
            'roles'=>$roles,
            'userRole'=>$userRole,
            'rolePermissions'=>$rolePermissions,
            'userPermissions'=>$userPermissions
            ]);
    }


    public function update(Request $request, User $user)
    {
        //validate the fields
        $request->validate([
            'name' => 'required|max:255',
            'Designation' => 'required|max:255',
            'mobile' => 'required|max:255',
            'username' => [
                'nullable','alpha_dash','max:30',
                Rule::unique('users')->ignore($user->id),
            ],
            'email' => [
                'required','email','max:40',
                Rule::unique('users')->ignore($user->id),
            ],
            'password' => 'confirmed',
        ]);

        $user->name = $request->name;
        $user->username = $request->username;
        $user->Designation = $request->Designation;
        $user->mobile = $request->mobile;
        $user->email = $request->email;
        if($request->password != null){
            $user->password = Hash::make($request->password);
        }
        $user->save();

        //$user->roles()->detach();
        $user->permissions()->detach();
//return $request->roles;
        if($request->roles != null){
            $user->roles()->sync($request->roles);
            $user->save();
        }
/*
        if($request->permissions != null){            
            foreach ($request->permissions as $permission) {
                $user->permissions()->attach($permission);
                $user->save();
            }
        }
        */

        return redirect()->route('users.index');

    }

    public function profile(){
        return view('admin.profile.profile');
    }
    
    public function editProfile(){
        $user = User::find(auth()->user()->id);
        return view('admin.profile.editProfile',compact('user'));
    }

    public function updateProfile(Request $request){
        $this->validate($request, array(
            'name' => 'required|string|max:255',
            'Designation' => 'required|string|max:100',
            'mobile' => 'required|string|max:14',
            'username' => 'required|alpha_dash|max:30|unique:users,username,'.auth()->user()->id,
            'email' => 'required|email|max:40|unique:users,email,'.auth()->user()->id,
            'photo' => 'nullable|mimes:jpg,jpeg,png|max:300',
        ));
                              
        $data = User::find(auth()->user()->id);
        
        $data->name = $request->name;
        $data->Designation = $request->Designation;
        $data->mobile = $request->mobile;
        $data->email = $request->email;
        if(isset($request->photo)){
            if (file_exists( public_path('upload\\profile_photo\\') . $data->photo)) {
                unlink(public_path('upload\\profile_photo\\') . $data->photo);
            }
      
            $fileName = time().'.'.$request->photo->extension();  
            $upload_path = public_path('upload/profile_photo');
            $request->photo->move($upload_path, $fileName);
            $data->photo = $fileName;
        }
        $data->save();
        session()->flash('success','Successfully Save');
        return redirect()->route('profile');
    }

    public function chengePassword(Request $request){
    	$this->validate($request, array(
            'CurrentPassword'=>'required|max:15',
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            ));

    	if(Hash::check($request->CurrentPassword, auth()->user()->password )){                      
	        $obj_user = User::find(auth()->user()->id);
	        $obj_user->password = Hash::make($request->password);
	        $obj_user->save();
            session()->flash('success', "Password chenged.");
	        return redirect()->back();            
    	}else{
            session()->flash('warning', "CurrentPassword does not match.");
    		return redirect()->back();
    	}

    } 


    public function destroy(User $user)
    {
        $user->roles()->detach();
        $user->permissions()->detach();
        $user->delete();

        return redirect()->route('users.index');
    }

    public function ban(Request $request)
    {
        if($request->days != 0 ){
            // ban for days
            $ban_days = Carbon::now()->addDays($request->days);
        }else{
            $ban_days = $request->days;
        }

        // ban user
        $user = User::find($request->user_id);
        if($user){
            $user->banned_till = $ban_days;
            $user->save();
            session()->flash('success', "Successfully ban.");
        }
	    return redirect()->back(); 
    }

    public function unban($id)
    {
        $user = User::find($id);
        if($user){
            $user->banned_till = null;
            $user->save();
            session()->flash('success', "Successfully unban.");
        }
	    return redirect()->back();   
    }

    public function bannedStatus()
    {
        $user_id = 1;
        $user = User::find($user_id);
    
        $message = "The user is not banned";
        if ($user->banned_till != null) {
            if ($user->banned_till == 0) {
                $message = "Banned Permanently";
            }
    
            if (now()->lessThan($user->banned_till)) {
                $banned_days = now()->diffInDays($user->banned_till) + 1;
                $message = "Suspended for " . $banned_days . ' ' . Str::plural('day', $banned_days);
            }
        }
    
    }



}
