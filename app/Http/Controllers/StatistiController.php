<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Color;
use App\Models\Size;

use function Termwind\render;

class StatistiController extends Controller
{
    public static function getCategoryStatistics()
    {
        $statistis = Product::selectRaw('count(*) as count, category_id')
            ->groupBy('category_id')
            ->get()
            ->map(function ($item) {
                $category = Category::select('name')
                    ->where('id', $item->category_id)
                    ->first();
                $item->name = $category->name;
                return $item;
            });
        return response()->json(["message" => "success", "data" => $statistis]);
    }

    public static function getNewProductsStatistics()
    {
        $statistis = Product::selectRaw('count(*) as count, category_id')
            ->whereMonth('created_at', 12)
            ->whereYear('created_at', 2022)
            ->groupBy('category_id')
            ->get()
            ->map(function ($item) {
                $category = Category::select('name')
                    ->where('id', $item->category_id)
                    ->first();
                $item->name = $category->name;
                return $item;
            });
        $statistis2 = Product::selectRaw('count(*) as count, category_id')
            ->whereMonth('created_at', 1)
            ->whereYear('created_at', 2023)
            ->groupBy('category_id')
            ->get()
            ->map(function ($item) {
                $category = Category::select('name')
                    ->where('id', $item->category_id)
                    ->first();
                $item->name = $category->name;
                return $item;
            });
        $statistis3 = Product::selectRaw('count(*) as count, category_id')
            ->whereMonth('created_at', 2)
            ->whereYear('created_at', 2023)
            ->groupBy('category_id')
            ->get()
            ->map(function ($item) {
                $category = Category::select('name')
                    ->where('id', $item->category_id)
                    ->first();
                $item->name = $category->name;
                return $item;
            });
        return response()->json(["message" => "success", "data" => ["December" => $statistis, "January" => $statistis2, "February" => $statistis3]]);
    }

    public static function getSaleOffProductsStatistics()
    {
        $statistis = Product::selectRaw('name, sale_off, category_id')
            ->where('sale_off', '>', 0)
            ->get()
            ->sortByDesc('sale_off')
            ->take(10)
            ->map(function ($item) {
                $category = Category::select('name')
                    ->where('id', $item->category_id)
                    ->first();
                $item->category_name = $category->name;
                return $item;
            });
        return response()->json(["message" => "success", "data" => $statistis]);
    }

    public static function getRankCostProduct()
    {
        $statistis = Product::select(['name', 'cost'])
            ->where('cost', '>=', 0)->get();

        return $statistis;
    }
}