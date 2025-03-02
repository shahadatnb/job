<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;
use App\Traits\CommonTrait;

class LocationController extends Controller
{ 
    use CommonTrait;

    public function index()
    {
        $locations = Location::with('locationParant')->get();
        $plocations = $this->zilaArray();

        return view('admin.location.locations', compact('locations','plocations'));
    }

    public function create()
    {
        $plocations = $this->zilaArray();
        return view('admin.location.edit', compact('plocations'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:locations',
            'parent_id' => 'nullable',
        ]);

        $data_arr = explode(", ",$request->name);
        $data_arr_bn = $request->name_bn !='' ? explode(", ",$request->name_bn) : null;

        foreach ($data_arr as $key => $value) {
            $name_bn = $data_arr_bn ? $data_arr_bn[$key] : null;
            // $category = new Location();
            // $category->name = $value;
            // $category->name_bn = $data_arr_bn ? $data_arr_bn[$key] : null;
            // $category->parent_id = $request->parent_id;
            // $category->save();

            Location::updateOrCreate(
                ['name'=>$value,'parent_id'=>$request->parent_id],['name_bn'=>$name_bn]);
        }

        return redirect()->back()->with('success', 'Location added successfully');
    }

    public function show(Location $location)
    {
        //
    }

    public function edit(Location $location)
    {        
        $plocations = $this->zilaArray();

        return view('admin.location.edit', compact('location','plocations'));
    }

    public function update(Request $request, Location $location)
    {
        $this->validate($request, array(
            'name'=>'required|max:255|unique:locations,name,'.$location->id,
            'parent_id' => 'nullable',
        ));

        $location->name = $request->name;
        $location->name_bn = $request->name_bn;
        $location->parent_id = $request->parent_id;
        $location->save();
        session()->flash('success', "Updated.");
        return redirect()->route('location.index');
    }

    
	public function childLocation(Request $request)
	{
		$location = Location::find($request->option);
		// Find all the children (sub-categories) from the parent location
		// so we can display then in the sub-location drop-down list.
		$sublocation = $location->locationChild();
		//dd($sublocation);
		// Return a Response, and make a request to get the id and location (name)
		return \Response::make($sublocation->get(['id', 'name']));
	}

    public function destroy(Location $location)
    {
        $location->delete();
        return redirect()->back()->with('success', 'Location deleted successfully');
    }
}
