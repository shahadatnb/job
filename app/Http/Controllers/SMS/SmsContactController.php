<?php

namespace App\Http\Controllers\SMS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SMS\SmsContact;
use App\Models\SMS\SmsContactCategory;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ImportContact;

class SmsContactController extends Controller
{
    public function index(){
        $contacts = SmsContact::where('branch_id', session('branch')['id'])->paginate(1000);
        return view('admin.sms.contacts.index', compact('contacts'));
    }

    public function import(Request $request){
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);
        
        Excel::import(new ImportContact, $request->file('file'));

        session()->flash('success', 'Imported Successfully!');
        return redirect()->back();
    }

    public function create(){
        $categories = SmsContactCategory::where('branch_id', session('branch')['id'])->pluck('name', 'id')->toArray();
        return view('admin.sms.contacts.edit', compact('categories'));
    }

    public function store(Request $request){
        $this->validate($request, array(
            'name'=>'required|max:255',
            'mobile'=>'nullable|max:25|unique:sms_contacts,mobile',
            'note'=>'nullable|max:255'
        ));

        $contact = new SmsContact();
        $contact->branch_id = session('branch')['id'];
        $contact->name = $request->name;
        $contact->mobile = $request->mobile;
        $contact->category_id = $request->category_id;
        $contact->note = $request->note;
        $contact->save();
        session()->flash('success', 'Contact added successfully');
        return redirect()->route('contact.index');
    }

    public function addCategory(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json(['status'=>false,'errors'=>$validator->errors()->all()]);
        }
        $category = new SmsContactCategory();
        $category->branch_id = session('branch')['id'];
        $category->name = $request->name;
        $category->save();
        return response()->json(['status'=>true,'category'=>$category]);
    }

    public function edit(SmsContact $contact){
        $categories = SmsContactCategory::where('branch_id', session('branch')['id'])->pluck('name', 'id')->toArray();
        return view('admin.sms.contacts.edit', compact('contact', 'categories'));
    }

    public function update(Request $request, SmsContact $contact){
        $this->validate($request, array(
            'name'=>'required|max:255',
            'mobile'=>'nullable|max:25|unique:sms_contacts,mobile,'.$contact->id,
            'note'=>'nullable|max:255'
        ));

        $contact->name = $request->name;
        $contact->mobile = $request->mobile;
        $contact->category_id = $request->category_id;
        $contact->note = $request->note;
        $contact->save();
        session()->flash('success', 'Contact updated successfully');
        return redirect()->back();
    }

    public function destroy(SmsContact $contact){
        $contact->delete();
        session()->flash('success', 'Contact deleted successfully');
        return redirect()->route('contact.index');
    }
}
