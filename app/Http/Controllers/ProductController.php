<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ThongSoGong;
use App\Models\ThongSoTrong;

class ProductController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query');
        $products = Product::where('name', 'LIKE', '%' . $query . '%')->get();
        return view('products.search', ['products' => $products]);
    }

    public function detail($id)
    {
        $product = Product::where('MaSP',  $id)->first();
        $gongs = ThongSoGong::all();
        $trongs = ThongSoTrong::all();
        return view('products.detail', ['product' => $product, 'trongs' => $trongs, 'gongs' => $gongs]);
    }
}
