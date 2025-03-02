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

class ImportContact implements ToCollection, WithHeadingRow, WithValidation
{
    public function Collection(Collection $rows)
    {
        foreach ($rows as $row) 
        {
            if(!empty($row['category'])){
                $category = SmsContactCategory::firstOrCreate(
                    ['name' => $row['category']],
                );
                $category_id = $category->id;
            }

            SmsContact::create([
                'name'  => $row['name'],
                'mobile' => $row['mobile'],
                'note' => $row['note'] ?? null,
                'category_id' => $row['category'] ? $category_id : null,
            ]);
        }
    }
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'mobile' => ['required', 'unique:sms_contacts,mobile'],//'digits:11',
            'note' => ['nullable', 'max:255'],
            'category' => ['nullable', 'string'],
        ];
    }
}
