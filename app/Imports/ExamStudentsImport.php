<?php

namespace App\Imports;

use App\Models\Student\ExamStudent;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Enums\StudentStatus;
use Illuminate\Validation\Rules\Enum;

class ExamStudentsImport implements ToModel, WithHeadingRow, WithValidation
{

    /*  
    public function collection(Collection $rows)
    {      
        foreach ($rows as $row)
        {
            $data['name'] = $row['name']?? null;
            $data['class_roll'] = $row['class_roll'];
            $data['reg_no'] = $row['reg_no']?? null;
            $data['session'] = $row['session']?? null;
            $data['semester'] = $row['semester']?? null;
            $data['institute'] = $row['institute']?? null;
            $data['shift'] = $row['shift']?? null;
            $data['ref_subject'] = $row['ref_subject']?? null;
            $data['technology'] = $row['technology']?? null;
            $data['probidhan'] = $row['probidhan']?? null;
            $data['mobile'] = $row['mobile']?? null;
            //dd($data); exit;
            ExamStudent::create($data);
        }
    }
    */
    public function model(array $row)
    {
        $data['name'] = isset($row['name']) && !empty($row['name'])? trim($row['name']) : null;
        $data['class_roll'] =  trim($row['class_roll']);
        $data['reg_no'] = isset($row['reg_no']) && !empty($row['reg_no'])? trim($row['reg_no']): null;
        $data['session'] = isset($row['session']) && !empty($row['session'])? trim($row['session']): null;
        $data['semester'] = isset($row['semester']) && !empty($row['semester'])? trim($row['semester']): null;
        $data['institute'] = isset($row['institute'])? trim($row['institute']): null;
        $data['shift'] = isset($row['shift']) && !empty($row['shift'])? trim($row['shift']): null;
        $data['student_group'] = isset($row['student_group'])? trim($row['student_group']): null;
        $data['ref_subject'] = isset($row['ref_subject']) && !empty($row['ref_subject'])? $row['ref_subject']: null;
        $data['technology'] = isset($row['technology']) && !empty($row['technology'])? trim($row['technology']): null;
        $data['probidhan'] = isset($row['probidhan']) && !empty($row['probidhan'])? trim($row['probidhan']): null;
        $data['mobile'] = isset($row['mobile']) && !empty($row['mobile'])? trim($row['mobile']): null;
        $data['status'] = isset($row['status'])? trim($row['status']): null;
        $data['remarks'] = isset($row['remarks']) && !empty($row['remarks'])? trim($row['remarks']): null;
        //dd($data); exit;
        return new ExamStudent($data);
    }

    public function rules(): array
    {
        return [
            'name' => ['nullable', 'string', 'max:150'],
            'class_roll' => ['required','unique:exam_students,class_roll'],
            'reg_no' => ['nullable', 'max:50'],
            'session' => ['nullable', 'max:50'],
            'semester' => ['required', 'string', 'max:50'],
            'institute' => ['required', 'string', 'max:150'],
            'shift' => ['nullable', 'string', 'max:50'],
            'student_group' => ['required', 'string', 'max:50'],
            'ref_subject' => ['nullable', 'string', 'max:1050'],
            'technology' => ['nullable', 'string', 'max:50'],
            'probidhan' => ['nullable', 'max:50'],
            'mobile' => ['nullable', 'max:50'],
            'status' => ['required','in:Regular,Irregular'],
        ];
    }
}
