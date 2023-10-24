<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Company;

class EditController extends Controller
{
    public function edit($id) {
        $product = Product::find( $id );
        $companis = Company::get();

        return view('edit',['product' => $product, 'companies' =>$companis]);
    }
}
