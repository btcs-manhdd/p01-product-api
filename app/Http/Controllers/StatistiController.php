<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Color;
use App\Models\Size;

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
                $item->category_name = $category->name;
                return $item;
            });
        return $statistis;
    }

    public static function getNewProductsStatistics()
    {
        $statistis = Product::selectRaw('count(*) as count, category_id')
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('category_id')
            ->get()
            ->map(function ($item) {
                $category = Category::select('name')
                    ->where('id', $item->category_id)
                    ->first();
                $item->category_name = $category->name;
                return $item;
            });
        return $statistis;
    }

    public static function getSaleOffProductsStatistics()
    {
        $statistis = Product::selectRaw('name, sale_off, category_id')
            ->where('sale_off', '>=', 0)
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
        return $statistis;
    }

    public static function getRankCostProduct()
    {
        $statistis = Product::select(['name', 'cost'])
            ->where('cost', '>=', 0)->get();

        return $statistis;
    }
}