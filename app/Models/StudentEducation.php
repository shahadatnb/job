<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentEducation extends Model
{
    use HasFactory;

    public function exam()
    {
        return $this->belongsTo(EduLevel::class, 'edu_level_id');
    }

    public function board()
    {
        return $this->belongsTo(EduBoard::class, 'edu_board_id');
    }

    public function group()
    {
        return $this->belongsTo(EduGroup::class, 'edu_group_id');
    }
}
