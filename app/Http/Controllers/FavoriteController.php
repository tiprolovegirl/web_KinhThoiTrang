<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FavoriteController extends Controller
{
     public function addFavorite(Request $request, $productId)
     {
         $favorites = session()->get('favorites', []);

         if (!in_array($productId, $favorites)) {
             $favorites[] = $productId;
             session()->put('favorites', $favorites);
             return redirect()->back()->with('success', 'Product added to favorites!');
         }

         return redirect()->back()->with('success', 'Product already in favorites!');
     }

     public function removeFavorite($productId)
     {
         $favorites = session()->get('favorites', []);

         if (($key = array_search($productId, $favorites)) !== false) {
             unset($favorites[$key]);
             session()->put('favorites', array_values($favorites));

             return redirect()->back()->with('success', 'Product removed from favorites!');
         }

         return redirect()->back()->with('error', 'Product not found in favorites!');
     }

    public function index()
    {
        $favorites = session()->get('favorites', []);
        $products = Product::whereIn('MaSP', $favorites)->get();
        return view('Pages.favorite', compact('products'));
    }

    public function getFavoriteCount()
    {
        $favorites = session()->get('favorites', []);
        $count = count($favorites);
        return response()->json(['count' => $count]);
    }
}
