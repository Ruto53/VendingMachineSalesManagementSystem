<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ArticleRequest;
use App\Models\Product;
use App\Models\Company;
use Illuminate\Support\Facades\DB; //トランザクション時に必要

class ProductController extends Controller
{
    //ログイン後の画面表示
    public function showList() {
        //全テーブルのレコードを取得
        $products = Product :: paginate(10);
        $companies = Company :: paginate(10);
        return view('list', ['products' => $products, 'companies' => $companies]);
    }

    //検索機能
    /*
    public function search(Request $request) {
        $keyword = $request ->keyword;
        $option = $request ->company;
        
        $model = new Product;
        list($products, $companies)=$model->searchProduct($keyword, $option);

        return view('list', ['products' => $products, 'companies' => $companies]);
    }
    */
    //検索機能（非同期）
    public function search() {
        $keyword = request() -> get('keyword');
        $option = request() -> get('company');
        $min_price = request() -> get('min_price');
        $max_price = request() -> get('max_price');
        $min_stock = request() -> get('min_stock');
        $max_stock = request() -> get('max_stock');

        $model = new Product;
        list($products, $companies) = $model->searchProduct($keyword, $option, $min_price, $max_price, $min_stock, $max_stock);

        $relation_company = array();
        foreach ($products as $product){
            $relation_company[]  = $product->company->company_name;
        }
        return response() -> json(['products' => $products, 'companies' => $relation_company]);
    }
    
    //新規追加画面表示
    public function addList() {
        //Companyテーブルから全データを取得
        $companies = Company::get();
        return view('add', ['companies' => $companies]);
    }

    //新規追加処理
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
    /*
    //削除処理
    public function delete(Request $request) {
        $id = $request -> product_id;
        $product = Product::find( $id );
        //レコードを削除
        $product -> delete();
        return redirect(route('list'));
    }
    */
    //削除処理非同期
    public function delete() {
        $id = request() -> get('id');
        $product = Product::find( $id );
        //レコードを削除
        $product -> delete();
    }

    //詳細を表示
    public function detail(Request $request) {
        $id = $request -> product_id;
        $product = Product::find( $id );
            
        return view('detail',['product' => $product]);
    }

    //編集画面表示
    public function edit($id) {
        $product = Product::find( $id );
        $companis = Company::get();
    
        return view('edit',['product' => $product, 'companies' =>$companis]);
    }

    //更新処理
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
