<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    //Productとリレーション（多対1）
    public function products() {
        return $this -> belongsTo(Product::class);
    }

}
