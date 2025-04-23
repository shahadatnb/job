<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EduBoard extends Model
{
    use HasFactory;

    public function edu_level()
    {
        return $this->belongsTo(EduLevel::class, 'edu_level_id');
    }
}
