<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Services\ProductService;

class ProductController extends Controller
{
    public function getAllProducts()
    {
        return response()->json([
            'message' => 'success',
            'data' => Product::with('subProducts')->get()
        ]);
    }

    public function getAllUserProducts()
    {
        $products = ProductService::getProductsForUser();
        return response()->json(['message' => 'success', 'data' => $products]);
    }

    public function getProductById($id)
    {
        return response()->json([
            'message' => 'success',
            'data' => Product::with(
                ['subProducts' => function ($query) {
                    $query->with('color')->with('size');
                }]
            )->where('id', $id)->first()
        ]);
    }

    public function getProductByIdForUser($id)
    {
        $userProduct = ProductService::getProductByIdForUser($id);
        return response()->json(['message' => 'success', 'data' => $userProduct]);
    }

    public function createProduct(Request $request)
    {
        $productInfo = $request->only(['name', 'description', 'cost', 'category_id', 'supplier_id', 'status']);
        $product = Product::create($productInfo);
        $product->status = true;
        $product->sale_off = 0;
        $product->save();
        ProductService::createSubProduct($request->sub_products, $product->id);
        return response()->json(['message' => 'susccess', 'data' => $product]);
    }

    public function updateProduct(Request $request, $id)
    {
        // ProductService::updateCost();
        // ProductService::updateSaleOff();
        $total = ProductService::updateSubProductQuantyByProductId($id);
        $productInfo = $request->only(['name', 'description', 'category_id', 'supplier_id', 'status', 'sale_off', 'sale_price']);
        $product = Product::find($id);
        $product->update($productInfo);
        $product->quantity = $total;
        $product->save();
        return response()->json(['message' => 'success', "data" => $product]);
    }

    public function deleteProduct($id)
    {
        $product = Product::find($id);
        $product->status = null;
        $product->save();
        return response()->json(['message' => 'success', 'data' => $product]);
    }
}