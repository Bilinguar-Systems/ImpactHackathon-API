<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ProductsController extends Controller
{
    public function createProduct(Request $request, $project_id) {
        $validatedData = $request->validate([
            'item_code' => 'required|unique:products|max:255',
            'items' => 'required|max:255',
            'no_of_stocks' => 'required|numeric',
            'end_cycle_date' => 'nullable|date',
            'duration' => 'required|numeric',
            'product_cost' => 'required',
        ]);

        return Product::create([
            'user_id' => Auth::user()->id,
            'project_id' => $project_id,
            'item_code' => $request->item_code,
            'items' => $request->items,
            'no_of_stocks' => $request->no_of_stocks,
            'end_cycle_date' => $request->end_cycle_date,
            'duration' => $request->duration,
            'product_cost' => $request->product_cost,
        ]);

    }

    public function getProduct($product_id) {
        return Product::where('id', '=', $product_id)->first();
    }

    public function searchProduct(Request $request) {
        $term = $request->get('term', '');
        return Product::where('items', 'like', '%' . $term .'%')->paginate(10);
    }

    public function deleteProduct($product_id) {
        $product = Product::where('id', '=', $product_id)->firstOrFail();

        if ($product->user_id != Auth::user()->id) {
            return response(null, Response::HTTP_FORBIDDEN);
        }

        $product->delete();

        return $product;
    }

}
