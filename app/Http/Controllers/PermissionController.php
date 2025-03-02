<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\Request;
use Str;

class PermissionController extends Controller
{

    public function index()
    {
        $permissions = Permission::orderBy('name', 'asc')->get();
        return view('admin.permission.index', ['permissions' => $permissions]);
    }


    public function create()
    {
        
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:permissions',
        ]);

        $slug = Str::slug($request->name);

        $permission = Permission::create([
            'name' => $request->name,
            'slug' => $slug
        ]);
        session()->flash('success', 'Permission created successfully');
        return redirect()->route('permissions.index');
    }


    public function show(Permission $permission)
    {
        //
    }


    public function edit(Permission $permission)
    {
        return view('admin.permission.edit', ['permission' => $permission]);
    }

    public function update(Request $request, Permission $permission)
    {
        $this->validate($request, [
            'name' => 'required',
            'slug' => 'required|unique:permissions,slug,'.$permission->id,
        ]);

        $permission->name = $request->name;
        $permission->slug = $request->slug;
        $permission->save();
        session()->flash('success', 'Permission updated successfully');
        return redirect()->back();
    }

    public function destroy(Permission $permission)
    {
        if($permission->roles->count() > 0){
            session()->flash('error', 'Permission cannot be deleted as it is assigned to one or more roles');
            return redirect()->back();
        }
        $permission->delete();
        session()->flash('success', 'Permission deleted successfully');
        return redirect()->back();
    }
}
