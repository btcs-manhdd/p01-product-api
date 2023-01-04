<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Size;

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

    public function createSize(Request $request)
    {
        $size = new Size();
        $size->name = $request->name;
        $size->save();
        return response()->json(['message' => 'success', 'data' => $size]);
    }

    public function updateSize(Request $request, $id)
    {
        $size = Size::find($id);
        $size->name = $request->name;
        $size->save();
        return response()->json(['message' => 'suscess', 'data' => $size]);
    }

    public function deleteSize($id)
    {
        return response()->json(['message' => 'deleteSize']);
    }
}