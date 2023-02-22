<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubProduct;
use App\Http\Services\ProductService;
use App\Models\Product;

class SubProductController extends Controller
{
    public function getAllSubProducts()
    {
        return response()->json([
            'message' => 'success',
            'data' => SubProduct::all()
        ]);
    }

    public function getSubProductById($id)
    {
        return response()->json([
            'message' => 'success',
            'data' => SubProduct::with('color')->with('size')->where('id', $id)->first()
        ]);
    }

    // public function createSubProduct(SubProductRequest $request)
    // {
    //     $subProduct = SubProduct::where('color_id', $request->color_id)
    //         ->where('size_id', $request->size_id)
    //         ->where('product_id', $request->product_id)
    //         ->first();
    //     if ($subProduct)
    //         return response()->json(
    //             [
    //                 'message' => 'Create sub product failed',
    //                 'errors' => [
    //                     'Color and size must be unique'
    //                 ]
    //             ],
    //             400
    //         );
    //     $subProductInfo = $request->only(['color_id', 'size_id', 'quantity', 'product_id', 'image_url']);
    //     $subProduct = SubProduct::create($subProductInfo);
    //     return response()->json(['message' => 'success', 'data' => $subProduct]);
    // }

    public function createSubProduct(Request $request)
    {
        $productId = $request->product_id;
        ProductService::createSubProduct($request->sub_products, $productId);
        $total = ProductService::updateSubProductQuantyByProductId($productId);
        $product = Product::find($productId);
        $product->quantity = $total;
        $product->save();
        return response()->json([
            'message' => 'Create sub product successfull',
            'data' => SubProduct::where('product_id', $productId)->get()
        ]);
    }

    public function updateSubProduct(Request $request, $id)
    {
        $subProductInfo = $request->only(['color_id', 'size_id', 'image_url', 'product_id']);
        $subProduct = SubProduct::find($id);
        if (!$subProduct)
            return response()->json(
                [
                    'message' => 'Sub product not found',
                    'errors' => [
                        'Sub product not found'
                    ]
                ],
                404
            );
        $subProduct->update($subProductInfo);
        return response()->json(['message' => 'success', 'data' => $subProduct]);
    }

    public function deleteSubProduct($id)
    {
        $subProduct = SubProduct::find($id);
        if (!$subProduct)
            return response()->json(
                [
                    'message' => 'Delete sub product failed',
                    'errors' => [
                        'Sub product not found'
                    ]
                ],
                404
            );
        if ($subProduct->quantity > 0)
            return response()->json(
                [
                    'message' => 'Delete sub product failed',
                    'errors' => [
                        'Sub product is not empty'
                    ]
                ],
                400
            );
        $subProduct->delete();
        return response()->json(['message' => 'Delete sub product successful', 'data' => null]);
    }
}
