<?php

namespace App\Http\Controllers;

use App\Models\EduBoard;
use App\Models\EduLevel;
use App\Models\StudentEducation;
use Illuminate\Http\Request;

class EduBoardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $eduBoards = EduBoard::all();
        $exams = EduLevel::where('is_active', 1)->pluck('name', 'id');
        return view('admin.edu_board.index', compact('eduBoards', 'exams'));
    }

    public function create()
    {
        $exams = EduLevel::where('is_active', 1)->pluck('name', 'id');
        return view('admin.edu_board.createOrEdit', compact('exams'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'edu_level_id' => 'required',
        ]);

        $eduBoard = new EduBoard;
        $eduBoard->name = $request->name;
        $eduBoard->edu_level_id = $request->edu_level_id;
        $eduBoard->is_active = 1;
        $eduBoard->save();

        session()->flash('success', 'Board created successfully');
        return redirect()->route('eduBoard.index');
    }

    public function show(EduBoard $eduBoard)
    {
        //
    }

    public function edit(EduBoard $eduBoard)
    {
        $exams = EduLevel::where('is_active', 1)->pluck('name', 'id');
        return view('admin.edu_board.createOrEdit', compact('eduBoard', 'exams'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EduBoard $eduBoard)
    {
        $request->validate([
            'name' => 'required',
            'edu_level_id' => 'required',
        ]);

        $eduBoard->name = $request->name;
        $eduBoard->edu_level_id = $request->edu_level_id;
        $eduBoard->is_active = $request->is_active;
        $eduBoard->save();

        session()->flash('success', 'Board updated successfully');
        return redirect()->route('eduBoard.index');
    }

    public function destroy(EduBoard $eduBoard)
    {
        $count = StudentEducation::where('edu_board_id', $eduBoard->id)->count();
        if ($count > 0) {
            session()->flash('error', 'This Board is in use');
            return back();
        }
        $eduBoard->delete();
        session()->flash('success', 'Successfully Deleted');
        return back();
    }
}
