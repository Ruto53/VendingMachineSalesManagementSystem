<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Sales extends Model
{
    use HasFactory;

    //protected $fillable = ['product_id'];
        //Productとリレーション（多対1）
    public function products() {
        return $this -> belongsTo(Product::class);
    }

    public function addPurchase($id){
        DB::table('sales')->insert([
            'product_id' => $id,
            'created_at' => NOW(),
            'updated_at' => NOW()
        ]);
    }



}
