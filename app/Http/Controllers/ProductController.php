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
    public function search(Request $request) {
        $keyword = $request ->keyword;
        $option = $request ->company;
        
        $model = new Product;
        list($products, $companies)=$model->searchProduct($keyword, $option);

        return view('list', ['products' => $products, 'companies' => $companies]);
    }
}
