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
    public function upazilaParmanent()
    {
        return $this->belongsTo(Location::class, 'parmanent_upazilla_id');
    }

    public function districtParmanent()
    {
        return $this->belongsTo(Location::class, 'parmanent_district_id');
    }

}
