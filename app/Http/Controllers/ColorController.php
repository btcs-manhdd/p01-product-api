<?php

namespace App\Http\Controllers;

use App\Http\Requests\ColorRequest;
use Illuminate\Http\Request;
use App\Models\Color;
use App\Models\SubProduct;

class ColorController extends Controller
{
    public function getAllColors()
    {
        return response()->json([
            'message' => 'success',
            'data' => Color::all()
        ]);
    }

    public function getColorById($id)
    {
        return response()->json([
            'message' => 'success',
            'data' => Color::where('id', $id)->first()
        ]);
    }

    public function createColor(ColorRequest $request)
    {
        $color = new Color();
        $color->name = $request->name;
        $color->code = $request->code;
        $color->save();
        return response()->json(['message' => 'success', 'data' => $color]);
    }

    public function updateColor(Request $request, $id)
    {
        $color = Color::find($id);
        if (!$color) {
            return response()->json([
                'message' => 'Color not found',
                'errors' => [
                    'Color not found'
                ]
            ], 404);
        }
        $checkName = Color::where('name', $request->name)->first();
        $checkCode = Color::where('code', $request->code)->first();
        if ($checkName && $checkCode) {
            return response()->json([
                'message' => 'Update failed', 'errors' => [
                    'Color ' . $checkName->name . ' is already exist',
                    'Color ' . $checkCode->code . ' is already exist'
                ]
            ], 422);
        }

        $color->name = $request->name;
        $color->code = $request->code;
        $color->save();
        return response()->json(['message' => 'success', 'data' => $color]);
    }

    public function deleteColor($id)
    {
        $product = SubProduct::where('color_id', $id)->first();
        if ($product) {
            return response()->json([
                'message' => 'Delete failed', 'errors' => [
                    'Color has products'
                ]
            ], 422);
        }
        $color = Color::find($id);
        if (!$color) {
            return response()->json([
                'message' => 'Color not found',
                'errors' => [
                    'Color not found'
                ]
            ], 404);
        }
        $color->delete();


        return response()->json(['message' => 'Delete success']);
    }
}
