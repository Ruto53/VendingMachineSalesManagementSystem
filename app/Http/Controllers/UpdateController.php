<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ArticleRequest;
use App\Models\Product;
use App\Models\Company;
use Illuminate\Support\Facades\DB;

class UpdateController extends Controller
{
    public function update(ArticleRequest $request, $id) {
        //トランザクション開始
        DB::beginTransaction();
        try{
            //処理の呼び出し
            $model = new Product(); //インスタンスの作成
            $model -> updateProduct($request, $id);//メソッドへrequestを呼び出しと値を渡し
            DB::commit();//トランザクションの処理を確定
        } catch(\Exception $e) {
            DB::rollback();
            return back();
        }
        
        return redirect(route('list'));
    }

}
