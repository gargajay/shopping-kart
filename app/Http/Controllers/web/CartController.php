<?php

namespace App\Http\Controllers\web;

use App\Helper\Helper;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cart = Cart::where('user_id', Auth::id())->get();
        $total =  Cart::cartTotal();
        $data['cart'] = $cart;
        $data['total'] = $total;
        return view('cart', $data);
    }

    public function addCart(Request $request)
    {
        $product = Product::find($request->id);
        $cart = new Cart();
        $cart->product_id = $product->id;
        $cart->qty = 1;
        $cart->user_id = Auth::id();
        $cart->save();
        $data['totalQty'] = Cart::totalQty();
        return  Helper::successResponse($data, 'Product added to cart successfully');
    }

     // for getting badge total items
    public function getQtyTotal(Request $request)
    {
        return Cart::totalQty();
    }

     // for delete cart item
    public function deleteCartItem(Request $request)
    {
        $cart = Cart::find($request->id);
        $cart->delete();
        $data['totalQty'] = Cart::totalQty();
        return  Helper::successResponse($data, 'Product removed  from cart successfully');
    }

    // for update cart item qty
    public function UpdateCartItem(Request $request)
    {
        $cart = Cart::find($request->id);
        $cart->qty= $request->qty;

        if($request->qty == 0){
            $cart->delete();
        }else{
            $cart->save();
        }
        $data['totalQty'] = Cart::totalQty();
        return  Helper::successResponse($data, 'Qty updated');
    }
}
