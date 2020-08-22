<?php

namespace App\Http\Controllers;

use App\Cart;
use App\CartProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class CartsController extends Controller
{
    public function createCart(Request  $request, $project_id) {
        $data = json_decode($request->getContent(), true);

        $rules = [
            'mode_of_payment' => 'required',
            'products.*.product_id' => 'required|numeric',
            'products.*.name' => 'required|max:255',
            'products.*.product_cost' => 'required|numeric',
            'products.*.quantity' => 'required|numeric',
        ];

        $validator = Validator::make($data, $rules);
        if (!$validator->passes() || sizeof($data) == 0) {
            return response()->json(['errors' => $validator->errors()], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $cart = Cart::create([
            'user_id' => Auth::user()->id,
            'project_id' => $project_id,
            'mode_of_payment' => $data['mode_of_payment']
        ]);

        foreach ($data['products'] as $product) {
            CartProduct::create([
                'user_id' => Auth::user()->id,
                'project_id' => $project_id,
                'product_id' => $product['product_id'],
                'cart_id' => $cart->id,
                'name' => $product['name'],
                'product_cost' => $product['product_cost'],
                'quantity' => $product['quantity'],
            ]);
        }

        $cart = Cart::where('id', '=', $cart->id)
            ->with('products')
            ->first();

        return $cart;
    }

    public function confirmOrder($cart_id) {
        $cart = Cart::where('id', '=', $cart_id)
            ->with('products')
            ->firstOrFail();

        $cart->is_paid = true;
        $cart->save();

        return $cart;
    }

    public function getCart($cart_id) {
        return Cart::where('id', '=', $cart_id)
            ->with('products')
            ->first();
    }

    public function getProjectCarts(Request  $request, $project_id) {
        $status = $request->get('status', null);

        $carts = Cart::where('project_id', '=', $project_id)
            ->with('products');

        if ($status != null)
            $carts->where('is_paid', '=', $status == 'paid' ? 1 : 0);

        $carts = $carts->paginate(10);

        return $carts;
    }

    public function getUserCarts(Request  $request, $user_id) {
        $status = $request->get('status', null);

        $carts = Cart::where('user_id', '=', $user_id)
            ->with('products');

        if ($status != null)
            $carts->where('is_paid', '=', $status == 'paid' ? 1 : 0);

        $carts = $carts->paginate(10);

        return $carts;
    }

    public function deleteCart($cart_id) {
        $cart = Cart::where('id', '=', $cart_id)->firstOrFail();
        $cart->delete();
        CartProduct::where('cart_id', '=', $cart_id)->delete();

        return $cart;
    }

}
