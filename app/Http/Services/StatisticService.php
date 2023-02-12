<?php

namespace App\Http\Services;

use App\Models\Product;
use App\Models\Category;

class StatisticService
{
    public static function getNewProductsInMonth($month, $year)
    {
        $statistis = Product::selectRaw('count(*) as count, category_id')
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->groupBy('category_id')
            ->get()
            ->map(function ($item) {
                $category = Category::select('name')
                    ->where('id', $item->category_id)
                    ->first();
                $item->name = $category->name;
                return $item;
            });
        return ["T" . $month => $statistis];
    }
    public static function getNewProductsStatistics()
    {
        $arr = [];
        $statistis = self::getNewProductsInMonth(date('m'), date('Y'));
        $statistis2 = self::getNewProductsInMonth(date('m', strtotime('-1 month')), date('Y', strtotime('-1 month')));
        $statistis3 = self::getNewProductsInMonth(date('m', strtotime('-2 month')), date('Y', strtotime('-2 month')));
        $newArr  = array_merge($arr, $statistis3, $statistis2, $statistis);
        return $newArr;
    }
    public static function getCategoryStatistics()
    {
        $statistis = Product::selectRaw('count(*) as count, category_id')
            ->where('status', 1)
            ->orWhere('status', NULL)
            ->groupBy('category_id')
            ->get()
            ->map(function ($item) {
                $category = Category::select('name')
                    ->where('id', $item->category_id)
                    ->first();
                $item->name = $category->name;
                return $item;
            });
        return $statistis;
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
        return $statistis;
    }
}
