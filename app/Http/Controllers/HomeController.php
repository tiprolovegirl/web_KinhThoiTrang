<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function home()
    {
        $products = Product::all();
        $chuck_products = Product::limit(12)->get();
        return view('Pages.home', ['products' => $products, 'chuck_products' => $chuck_products]);
    }
}
