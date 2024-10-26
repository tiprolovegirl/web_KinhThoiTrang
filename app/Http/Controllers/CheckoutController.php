<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CheckoutController extends Controller
{
    public function checkoutPayment(Request $request){
        $total = 0;
        $cart = session()->get('cart', []);
        foreach($cart as $item){
            $itemTotal = $item['price'] * $item['quantity'];
            $total += $itemTotal;
        }
        $acc = config('session.acc');
        $bank = config('session.bank');
        $des = 'MLB1';
        return view('checkout.order_payment', [
            'img' => "https://qr.sepay.vn/img?acc=$acc&bank=$bank&amount=$total&des=$des",
            'total' => $total,
            'cart' => $cart,
            'bank_name' => 'Ngân hàng TMCP Kỹ thương Việt Nam'
            ]);
    }

    public function paymentComplete(Request $request){
        return view('checkout.payment_complete');
    }
}
