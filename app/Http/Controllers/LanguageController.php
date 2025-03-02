<?php

namespace App\Http\Controllers;

use App\Models\Language;
use Illuminate\Http\Request;

class LanguageController extends Controller
{

    public function index()
    {
        $languages = Language::all();
        return view('admin.pages.language.index', compact('languages'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $this->validate($request, array(
        'code'=>'required|string|unique:languages,code',
        'en'=>'nullable|string|max:255',
        'bn'=>'nullable|string|max:255',
        ));

        $data = new Customer;
        $data->code = $request->code;
        $data->en = $request->en;
        $data->bn = $request->bn;
        $data->save();

        session()->flash('success', "Saved.");
        return redirect()->route('language.index');
    }

    public function show(Language $language)
    {
        
    }

    public function edit(Language $language)
    {
        return view('admin.pages.language.createOrEdit', compact('language'));
    }

    public function update(Request $request, Language $language)
    {
        $this->validate($request, array(
        'code'=>'required|string|unique:languages,code,'.$language->id,
        'en'=>'nullable|string|max:255',
        'bn'=>'nullable|string|max:255',
        ));

        $language->code = $request->code;
        $language->en = $request->en;
        $language->bn = $request->bn;
        $language->save();

        session()->flash('success', "Saved.");
        return redirect()->route('language.index');
    }

    public function destroy(Language $language)
    {
        //
    }
}
