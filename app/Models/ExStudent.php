<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExStudent extends Model
{
    use HasFactory;

    public function department()
    {
        return $this->belongsTo(EduGroup::class, 'department_id', 'id');
    }
}
