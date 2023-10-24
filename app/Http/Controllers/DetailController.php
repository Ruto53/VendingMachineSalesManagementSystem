<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Company;
use Illuminate\Support\Facades\DB;

class DetailController extends Controller
{
    public function detail($id) {
        $product = Product::find( $id );
        
        return view('detail',['product' => $product]);
    }

    public function showList() {
        $products = Product :: get();
        return redirect(route('list'));
    }

}
