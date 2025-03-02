<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = ['name', 'name_bn', 'parent_id'];

    public function locationParant(){
        return $this->belongsTo(Location::class, 'parent_id');
    }

    public function locationChild(){
        return $this->hasMany(Location::class, 'parent_id');
    }
}
