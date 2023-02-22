<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Models\Product;

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

    public function createCategory(CategoryRequest $request)
    {
        $category = new Category();
        $category->name = $request->name;
        $category->save();
        return response()->json(['message' => 'success', 'data' => $category]);
    }

    public function updateCategory(CategoryRequest $request, $id)
    {
        $category = Category::find($id);
        if (!$category) {
            return response()->json([
                'message' => 'Category not found',
                'errors' => [
                    'Category not found'
                ]
            ], 404);
        }
        $category->name = $request->name;
        $category->save();
        return response()->json(['message' => 'suscess', 'data' => $category]);
    }

    public function deleteCategory($id)
    {
        $product = Product::where('category_id', $id)->first();
        if ($product) {
            return response()->json([
                'message' => 'Delete failed', 'errors' => [
                    'Category has products'
                ]
            ], 422);
        }
        $category = Category::find($id);
        if (!$category) {
            return response()->json([
                'message' => 'Category not found',
                'errors' => [
                    'Category not found'
                ]
            ], 404);
        }
        $category->delete();
        return response()->json(['message' => 'Delete success']);
    }
}
