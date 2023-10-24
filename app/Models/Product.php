<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use App\Controllers\ArticleController;

class Product extends Model
{
    //companyとリレーション（多対1）
    public function company() {
        return $this -> belongsTo(Company::Class);
    }

    //salesとリレーション（1対多）
    public function sales() {
        return $this-> hasMany(Sales::Class);
    }

    public function searchProduct($key, $op) {
        if (!empty($key)) {//keyが空でない場合に処理を実行
            $products = Product::where('product_name', 'LIKE', "%{$key}%")
             ->orWhere('price', $key)
             ->orWhere('stock', $key)
             ->orWhereHas('company', function($query) use ($key) {
                $query->where('company_name', 'LIKE' , $key);
             })->paginate(10);
             $companies = Company :: paginate(10);
             return [$products, $companies];
             
        } else if (!empty($op)) {//$op　が空ではない場合、検索処理を実行します
            $products = Product::whereHas('company', function($query) use ($op) {
                $query -> where('company_name' , $op);
             }) -> paginate(10);
             $companies = Company :: paginate(10);
             return [$products, $companies];
        } else if (empty($key) && empty($op)) {//なにも検索するものが無い場合に実行
            $products = Product::paginate(10);
            $companies = Company :: paginate(10);
            return [$products, $companies];
        }
    }

    //DBへ新規登録
    public function registerProduct($data) {//$requestの受け取り
        if (!empty($data -> file('img_path'))) {//画像が選択されている時のみ発動
            $filename = $data->file('img_path')->getClientOriginalName();//画像のファイルネームを取得
            $img = $data->file('img_path')->storeAs('public/', $filename);//strage/publicに画像を保存
            $product = DB::table('products')->insert([
                'product_name' => $data->product_name,
                'company_id' => $data->company_id,
                'price' => $data->price,
                'stock' => $data->stock,
                'comment' => $data->comment,
                'img_path'=> $filename
                ]);
            } else {//画像が選択されていない場合
            $product = DB::table('products')->insert([
            'product_name' => $data->product_name,
            'company_id' => $data->company_id,
            'price' => $data->price,
            'stock' => $data->stock,
            'comment' => $data->comment
            ]);
        }
    }

    //DBの値を更新
    public function updateProduct($data, $id) {
        if (!empty($data -> file('img_path'))) {
        $filename = $data->file('img_path')->getClientOriginalName();//画像のファイルネームを取得
        $img = $data->file('img_path')->storeAs('public/', $filename);
        $product = DB::table('products')
        ->where('id',$id)
        ->update([
            'product_name' => $data->product_name,
            'company_id' => $data->company_id,
            'price' => $data->price,
            'stock' => $data->stock,
            'comment' => $data->comment,
            'img_path'=> $filename
        ]);
    } else {
        $product = DB::table('products')
            ->where('id',$id)
            ->update([
                'product_name' => $data->product_name,
                'company_id' => $data->company_id,
                'price' => $data->price,
                'stock' => $data->stock,
                'comment' => $data->comment,
            ]);
        }
    }
}
