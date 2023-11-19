<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Sales;
use Illuminate\Support\Facades\DB; 

class SalesController extends Controller
{
    /*//API処理を作成
    public function purchase(Request $request){
        $id = $request -> input('id');
        return response() -> json(['message' => $id]);
    }*/


    public function purchase(Request $request){
        $id = $request -> input('id');//product_idに4番が指定されていた場合、4が代入
        $quantity = $request -> input('quantity', 1);//購入する数を代入する。第二引数は送信されたデータが見つからない場合。今回は1とする。

        $product = Product::find($id);//idに一致するデータを取得

        //以下はバリデーション
        if(!$product) {//productに値が内場合
            return response() -> json(['message' => 'Product does not exist.'], 404);
        }
        if($product -> stock < $quantity) {//sotckの数が1以下の場合＝商品が不足
            return response() -> json(['message' => 'Item is out of stock.'], 400);
        }

        //トランザクション開始
        DB::beginTransaction();
        try{
        $product -> stock -= $quantity;//Producテーブルのstockの値を減少させて保存
        $product -> save();

        $sale = new Sales;
        $sale -> addPurchase($id);
        DB::commit();//トランザクションの処理を確定
        } catch(\Exception $e) {
            DB::rollback();
            return back();
        }
        return response() -> json(['message' => 'Purchase Success']);
    }

}
