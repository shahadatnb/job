<?php

namespace App\Models\SMS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class SmsLog extends Model
{
    use HasFactory;
    protected $fillable = [
        'branch_id','send_type', 'send_to', 'name', 'mobile', 'message', 'status', 'created_by', 'sms_count', 'response'
    ];

    public function user(){
        return $this->belongsTo(User::class, 'created_by');
    }
}
