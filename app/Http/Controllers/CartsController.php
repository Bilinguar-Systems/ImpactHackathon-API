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
            '*.product_id' => 'required|numeric',
            '*.name' => 'required|max:255',
            '*.product_cost' => 'required|numeric',
            '*.quantity' => 'required|numeric',
        ];

        $validator = Validator::make($data, $rules);
        if (!$validator->passes() || sizeof($data) == 0) {
            return response()->json(['errors' => $validator->errors()], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $cart = Cart::create([
            'user_id' => Auth::user()->id,
            'project_id' => $project_id,
        ]);

        foreach ($data as $product) {
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
}
