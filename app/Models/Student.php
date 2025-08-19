<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable; // for auth
use Illuminate\Foundation\Auth\User as Authenticatable; // for auth
use App\Notifications\CustomerResetPasswordNotification;
use Laravel\Sanctum\HasApiTokens;

class Student extends Authenticatable
{
    use Notifiable, HasApiTokens; // for auth
    protected $guard = 'student'; // for auth

    protected $fillable = [
        'name', 'phone', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new CustomerResetPasswordNotification($token));
    }

    public function upazila()
    {
        return $this->belongsTo(Location::class, 'upazila_id');
    }

    public function district()
    {
        return $this->belongsTo(Location::class, 'district_id');
    }
    public function upazilaPermanent()
    {
        return $this->belongsTo(Location::class, 'permanent_upazila_id');
    }

    public function districtPermanent()
    {
        return $this->belongsTo(Location::class, 'permanent_district_id');
    }

    public function educations()
    {
        return $this->hasMany(StudentEducation::class)->orderBy('passing_year', 'desc');
    }

    public function employments()
    {
        return $this->hasMany(StudentEmployment::class)->orderBy('end_date', 'desc');
    }

    public function trainings()
    {
        return $this->hasMany(StudentTraining::class);
    }

    public function skills()
    {
        return $this->hasMany(StudentSkill::class);
    }

    public function certifications()
    {
        return $this->hasMany(ProfessionalCertificate::class)->orderBy('end_date', 'desc');
    }

    public function references()
    {
        return $this->hasMany(References::class);
    }

    public function languages()
    {
        return $this->hasMany(LanguageProficiency::class);
    }

}
