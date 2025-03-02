<?php

namespace App\Imports;

use App\Models\Student\Student;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\ToCollection;

class ImportCgpa implements ToCollection, WithHeadingRow, WithValidation
{
    public function collection(Collection $rows)
    {
        //dd($rows); exit;
        foreach ($rows as $row) 
        {  
            $data['class_roll'] = trim($row['class_roll']);
            $data['exam_held'] = trim($row['exam_held']);
            if(!empty($row['cgpa']))
            {
                $data['cgpa'] = trim($row['cgpa']);
            }

            Student::where('class_roll', trim($row['class_roll']))->update($data);
            // Student::where('class_roll', $row['class_roll'])->update(['cgpa' => $row['cgpa'], 'exam_held' => $row['exam_held']]);//,'final_result_date' => $row['final_result_date']
            /*
            $student  = Student::where('class_roll', $row['class_roll'])->first();
            dd($student); exit;
            $student->cgpa = $row['cgpa'];
            $student->save();
            */
        }
        
    }
    public function rules(): array
    {
        return [
            'class_roll' => ['required', 'max:25'],
            'exam_held' => ['required', 'max:50'],
            //'reg_no' => ['nullable', 'max:255'],
            'cgpa' => ['nullable', 'numeric', 'max:5']
        ];
    }
}
