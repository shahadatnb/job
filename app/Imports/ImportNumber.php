<?php

namespace App\Imports;

use App\Models\SMS\SmsContact;
use App\Models\SMS\SmsContactCategory;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use App\Facades\CustomHelperFacade as CustomHelper;

class ImportNumber implements ToCollection, WithHeadingRow, WithValidation
{
    public function Collection(Collection $rows)
    {
        
        foreach ($rows as $row) 
        {
            //$numbers[$key] = substr($row['mobile'], 0, 1) == '1' ? '0'.$row['mobile'] : $row['mobile'];
        }
        
        //$contacts = implode('+', $numbers);
        //CustomHelper::send_sms($contacts, $request->content);
    }
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'mobile' => ['required', 'min:10', 'max:13'],
        ];
    }
}
