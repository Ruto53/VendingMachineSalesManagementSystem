<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ArticleRequest;
use App\Models\Product;
use App\Models\Company;
use Illuminate\Support\Facades\DB; //トランザクション時に必要

class AddController extends Controller
{
    //新規追加画面
    public function addList() {
        //Companyテーブルから全データを取得
        $companies = Company::get();
        return view('add', ['companies' => $companies]);
    }

    public function addSubmit(ArticleRequest $request) {
        ///トランザクション開始
        DB::beginTransaction();
        try{
            //処理の呼び出し
            $model = new Product(); //インスタンスの作成
            $model -> registerProduct($request);//メソッドへrequestを呼び出しと値を渡し
            DB::commit();//トランザクションの処理を確定
        }catch(\Exception $e){ //トランザクション外の動きをしたときの定型文
            DB::rollback();
            return back();
        }
        
        return redirect(route('add'));
    }

}
