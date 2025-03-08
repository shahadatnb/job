<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentEducation extends Model
{
    use HasFactory;

    public function exam()
    {
        return $this->belongsTo(EduLevel::class);
    }

    public function board()
    {
        return $this->belongsTo(EduBoard::class);
    }

    public function group()
    {
        return $this->belongsTo(EduGroup::class);
    }
}
