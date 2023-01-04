<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function getAllCategories()
    {
        return response()->json([
            'message' => 'success',
            'data' => Category::all()
        ]);
    }

    public function getCategoryById($id)
    {
        return response()->json([
            'message' => 'success',
            'data' => Category::where('id', $id)->first()
        ]);
    }

    public function createCategory(Request $request)
    {
        $category = new Category();
        $category->name = $request->name;
        $category->save();
        return response()->json(['message' => 'success', 'data' => $category]);
    }

    public function updateCategory(Request $request, $id)
    {
        $category = Category::find($id);
        $category->name = $request->name;
        $category->save();
        return response()->json(['message' => 'suscess', 'data' => $category]);
    }

    public function deleteCategory($id)
    {
        return response()->json(['message' => 'deleteCategory']);
    }
}