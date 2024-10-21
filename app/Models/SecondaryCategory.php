<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SecondaryCategory extends Model
{
    public function primaryCategory()
     {
         return $this->belongsTo(PrimaryCategory::class);//多対1（Many-to-One）のリレーションシップを定義する方法
     }
}
