<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $product = Product::where('MaSP', $request->product_id)->first();
        $cart = session()->get('cart', []);
        if (isset($cart[$product->MaSP])) {
            $cart[$product->MaSP]['quantity'] += $request->input('quantity');
            $cart[$product->MaSP]['do_tra'] = $request->input('do_trai');
            $cart[$product->MaSP]['do_phai'] = $request->input('do_phai');
            $cart[$product->MaSP]['trong'] = $request->input('trong');
            $cart[$product->MaSP]['gong'] = $request->input('gong');
        } else {
            $cart[$product->MaSP] = [
                'name' => $product->TenSP,
                'quantity' => $request->input('quantity', 1),
                'price' => $product->GiaBan,
                'picture' => $product->AnhSP,
                'do_trai' => $request->input('do_trai'),
                'do_phai' => $request->input('do_phai'),
                'gong' => $request->input('gong'),
                'trong' => $request->input('trong'),
            ];
        }
        session()->put('cart', $cart);
        return redirect()->route('cart.index')->with('success', 'Product added to cart!');
    }

    public function index()
    {
        // Fetch the cart from the session
        $cart = session()->get('cart', []);

        return view('Pages.cart', compact('cart'));
    }

    public function removeItem($id)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'Item removed from cart');
    }

    public function getCartCount()
    {
        $cart = session()->get('cart', []);
        $count = 0;

        foreach ($cart as $item) {
            $count += $item['quantity'];
        }

        return response()->json(['count' => $count]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = $request->quantity;
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'Cart updated successfully.');
    }
}
