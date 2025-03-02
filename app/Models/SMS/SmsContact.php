<?php

namespace App\Models\SMS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmsContact extends Model
{
    use HasFactory;

    protected $fillable = ['branch_id','name', 'mobile', 'note', 'category_id'];

    public function category(){
        return $this->belongsTo(SmsContactCategory::class, 'category_id');
    }
}
