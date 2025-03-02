<?php

namespace App\Http\Controllers\SMS;

use App\Http\Controllers\Controller;
use App\Models\SMS\SmsTemplate;
use Illuminate\Http\Request;

class SmsTemplateController extends Controller
{
    public function index(){
        $templates = SmsTemplate::where('branch_id', session('branch')['id'])->paginate(1000);
        return view('admin.sms.templates.index', compact('templates'));
    }

    public function create(){
        return view('admin.sms.templates.edit');
    }

    public function store(Request $request){
        $this->validate($request, array(
            'title'=>'required|max:255:unique:sms_templates,title',
            'content'=>'required|string',
        ));
        
        $template = new SmsTemplate();
        $template->branch_id = session('branch')['id'];
        $template->title = $request->title;
        $template->content = $request->content;
        $template->save();
        session()->flash('success', 'Template added successfully');
        return redirect()->route('smsTemplate.index');
    }

    public function show(SmsTemplate $smsTemplate){
        return response()->json($smsTemplate);
    }

    public function edit(SmsTemplate $smsTemplate){
        if($smsTemplate->branch_id != session('branch')['id']){
            session()->flash('error', 'You are not authorized to edit this template');
            return redirect()->back();
        }
        return view('admin.sms.templates.edit', compact('smsTemplate'));
    }

    public function update(Request $request, SmsTemplate $smsTemplate){
        $this->validate($request, array(
            'title'=>'required|max:255|unique:sms_templates,title,'.$smsTemplate->id,
            'content'=>'required|string',
        ));

        $smsTemplate->title = $request->title;
        $smsTemplate->content = $request->content;
        $smsTemplate->save();
        session()->flash('success', 'Template updated successfully');
        return redirect()->back();
    }

    public function destroy(SmsTemplate $smsTemplate){
        $smsTemplate->delete();
        session()->flash('success', 'Template deleted successfully');
        return redirect()->route('smsTemplate.index');
    }
}
