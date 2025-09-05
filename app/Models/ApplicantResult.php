<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicantResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'application_id',
        'present_salary',
        'preferred_salary',
        'marks',
        'position',
    ];
}
