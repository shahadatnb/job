<?php

namespace App\Models\SMS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmsContactCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'branch_id','name'
    ];
}
