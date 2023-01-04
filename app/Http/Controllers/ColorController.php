<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Color;

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

    public function createColor(Request $request)
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
        if (isset($request->name)) {
            $color->name = $request->name;
        }
        if (isset($request->code)) {
            $color->code = $request->code;
        }
        $color->save();
        return response()->json(['message' => 'success', 'data' => $color]);
    }

    public function deleteColor($id)
    {
        return response()->json(['message' => 'deleteColor']);
    }
}