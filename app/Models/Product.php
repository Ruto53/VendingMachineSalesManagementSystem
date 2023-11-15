<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use App\Controllers\ArticleController;
use Kyslik\ColumnSortable\Sortable; 

class Product extends Model
{
    use Sortable;

    //companyとリレーション（多対1）
    public function company() {
        return $this -> belongsTo(Company::Class);
    }

    //salesとリレーション（1対多）
    public function sales() {
        return $this-> hasMany(Sales::Class);
    }
    
    //検索機能
    public function searchProduct($key, $op, $min, $max) {
        $query_products = Product::query();
        $query_companies = Company::query();

        if(!empty($min) && !empty($max)){
            //下限と上限が入力されている状態
            $query_products -> whereBetween('price',[$min, $max]);
        }else if(!empty($min) && empty($max)){
            //下限のみが入力されている状態
            $query_products -> where ('price', '>=', $min);
        }else if(empty($min) && !empty($max)){
            //上限のみが入力されている状態
            $query_products -> where ('price', '<=', $max);
        }
        
        if(!empty($key) && !empty($op)){
            $query_products -> whereHas('company', function($query) use ($op) {
                $query -> where('company_name' , $op);
             })
            ->where('product_name', 'LIKE', "%{$key}%")
             ->orWhere('price', $key)
             ->orWhere('stock', $key)
             ->orWhereHas('company', function($query) use ($key) {
                $query->where('company_name', 'LIKE' , $key);
             });
        }else if (!empty($key)) {//keyが空でない場合に処理を実行
            $query_products -> where('product_name', 'LIKE', "%{$key}%")
             ->orWhere('price', $key)
             ->orWhere('stock', $key)
             ->orWhereHas('company', function($query) use ($key) {
                $query->where('company_name', 'LIKE' , $key);
             });
        } else if (!empty($op)) {//$op　が空ではない場合、検索処理を実行します
            $query_products -> whereHas('company', function($query) use ($op) {
                $query -> where('company_name' , $op);
             });
        }

        


        $products = $query_products-> paginate(10);//$productsに検索したデータを代入
        $companies = $query_companies -> paginate(10);//$companiesに検索したデータを代入
        return [$products, $companies];
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
