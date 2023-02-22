<?php

namespace App\Http\Controllers;

use App\Http\Services\StatisticService;
use App\Models\Product;


use function Termwind\render;

class StatisticController extends Controller
{
    public static function getCategoryStatistics()
    {
        return response()->json([
            "message" => "success",
            "data" => StatisticService::getCategoryStatistics()
        ]);
    }

    public static function getNewProductsStatistics()
    {

        return response()->json([
            "message" => "success",
            "data" => StatisticService::getNewProductsStatistics()
        ]);
    }

    public static function getSaleOffProductsStatistics()
    {
        return response()->json([
            "message" => "success",
            "data" => StatisticService::getSaleOffProductsStatistics()
        ]);
    }

    public static function getRankCostProduct()
    {
        $statistis = Product::select(['name', 'cost'])
            ->where('cost', '>=', 0)->get();

        return $statistis;
    }
}
