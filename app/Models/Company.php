<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
   //Productとリレーション設定（1対多）hasMany設定
    public function products() {
        return $this->hasMany(Product::class);
    }
}
