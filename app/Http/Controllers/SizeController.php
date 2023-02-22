<?php

namespace App\Http\Controllers;

use App\Http\Requests\SizeRequest;
use App\Models\Size;
use App\Models\SubProduct;

class SizeController extends Controller
{
    public function getAllSizes()
    {
        return response()->json([
            'message' => 'success',
            'data' => Size::all()
        ]);
    }

    public function getSizeById($id)
    {
        return response()->json([
            'message' => 'success',
            'data' => Size::where('id', $id)->first()
        ]);
    }

    public function createSize(SizeRequest $request)
    {
        $size = new Size();
        $size->name = $request->name;
        $size->save();
        return response()->json(['message' => 'success', 'data' => $size]);
    }

    public function updateSize(SizeRequest $request, $id)
    {
        $size = Size::find($id);
        if (!$size) {
            return response()->json([
                'message' => 'Size not found',
                'errors' => [
                    'Size not found'
                ]
            ], 404);
        }
        $size->name = $request->name;
        $size->save();
        return response()->json(['message' => 'suscess', 'data' => $size]);
    }

    public function deleteSize($id)
    {
        $product = SubProduct::where('size_id', $id)->first();
        if ($product) {
            return response()->json([
                'message' => 'Detele failed',
                'errors' => [
                    'Size has products'
                ]
            ], 422);
        }
        $size = Size::find($id);
        if (!$size) {
            return response()->json([
                'message' => 'Size not found',
                'errors' => [
                    'Size not found'
                ]
            ], 404);
        }
        $size->delete();
        return response()->json(['message' => 'Delete success']);
    }
}
