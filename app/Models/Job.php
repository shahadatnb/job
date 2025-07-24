<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    public function designation()
    {
        return $this->belongsTo(Designation::class);
    }

    public function eduLevel()
    {
        return $this->belongsTo(EduLevel::class);
    }

    public function eduLevel2(){
        return $this->belongsTo(EduLevel::class, 'edu_level2_id');
    }
}
