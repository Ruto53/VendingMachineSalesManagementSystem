<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class DeleteController extends Controller
{
    //削除処理
    public function delete($id) {
        $product = Product::find( $id );
        //レコードを削除
        $product -> delete();
        return redirect(route('list'));
    }
}
