<?php
namespace App\Traits;

use App\Models\Student\Student;
use App\Models\Student\Semester;
use App\Models\Student\ClassConfig;

trait StudentTrait {

    public function semesterArray() {
        $semesters = Semester::where('status', 1)->where('branch_id', session('branch')['id'])->get();
        $datas = [];
        foreach ($semesters as $semester) {
            $datas[$semester->id] = $semester->name;
        }
        return $datas;
    }

    public function sectionArray() {
        $groups = ClassConfig::where('status', 1)->where('branch_id', session('branch')['id'])->get();
        //dd($groups);
        $datas = [];        
        foreach ($groups as $group) {            
            $datas[$group->id] = $group->name;
        }
        return $datas;
    }

    public function newReg(){
        $student = Student::where('branch_id', session('branch')['id'])->orderBy('reg_no','desc')->first();
        if($student){
            /*
            $year = substr($student->reg_no,0,4);
            if($year == date('Y')){
                return ++$student->reg_no;
            }else{
                return date('Y').$dept.'001';
            }
            */
            return ++$student->reg_no;
        }else{
            return date('y').'001';
        }
    }

}
