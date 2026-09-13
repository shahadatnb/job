<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobApplication extends Model
{
    use HasFactory;

    public function job()
    {
        return $this->belongsTo(Job::class);
    }

    public function applicant()
    {
        return $this->belongsTo(Applicant::class);
    }

    public function application_status()
    {
        return $this->belongsTo(ApplicationStatus::class, 'status');
    }

    public function result(){
        return $this->hasOne(ApplicantResult::class, 'application_id');
    }

    
}
