<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    public $timestamps = false;
    
    public function subMenu(){
    	return $this->hasMany(MenuItem::class,'parent_id','id')->orderBy('sl');
    }
}
