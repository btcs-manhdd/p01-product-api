<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubProduct;

class SubProductController extends Controller
{
    public function getSubProductById($id)
    {
        return response()->json([
            'message' => 'success',
            'data' => SubProduct::with('color')->with('size')->where('id', $id)->first()
        ]);
    }

    public function createSubProduct(Request $request)
    {
        $subProductInfo = $request->only(['color_id', 'size_id', 'quantity', 'product_id', 'image_url']);
        $subProduct = SubProduct::create($subProductInfo);
        return response()->json(['message' => 'success', 'data' => $subProductInfo]);
    }

    public function updateSubProduct(Request $request, $id)
    {
        $subProductInfo = $request->only(['color_id', 'size_id', 'image_url']);
        $subProduct = SubProduct::find($id);
        $subProduct->update($subProductInfo);
        return response()->json(['message' => 'success', 'data' => $subProduct]);
    }

    public function deleteSubProduct($id)
    {
        $subProduct = SubProduct::find($id);
        $subProduct->delete();
        return response()->json(['message' => 'success', 'data' => null]);
    }

}
