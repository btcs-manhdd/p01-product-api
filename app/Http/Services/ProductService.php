<?php

namespace App\Http\Services;

use App\Models\SubProduct;
use App\Models\Product;
use App\Models\Color;
use App\Models\Size;
use App\Models\Category;
use Illuminate\Support\Facades\Http;

class ProductService
{
    public static function createSubProduct($subProducts, $productId)
    {
        foreach ($subProducts as $colorId => $subProduct) {
            foreach ($subProduct as $subProductItem) {
                $subProductInfo = [
                    'product_id' => $productId,
                    'size_id' => $subProductItem['size_id'],
                    'color_id' => $colorId,
                    'quantity' => $subProductItem['quantity'],
                    'image_url' => $subProductItem['image_url'],
                ];
                SubProduct::create($subProductInfo);
            }
        }
    }
    public static function convertSubProduct($subProductInput)
    {
        $subProduct = [
            'id' => $subProductInput->id,
            'size' => null,
            'color' => null,
            'quantity' => $subProductInput->quantity,
            'image_url' => $subProductInput->image_url
        ];
        $subProduct["color"] = Color::find($subProductInput->color_id)->name;
        $subProduct["size"] = Size::find($subProductInput->size_id)->name;
        return $subProduct;
    }

    public static function getProductByIdForUser($id)
    {
        $userProduct = Product::find($id);
        $subProducts = SubProduct::where('product_id', $userProduct->id)->get();
        $newSubProducts = $subProducts->map(function ($subProduct) {
            return ProductService::convertSubProduct($subProduct);
        });
        $userProduct->sub_products = $newSubProducts;
        return $userProduct;
    }

    public static function getProductsForUser()
    {
        $userProducts = Product::all();
        foreach ($userProducts as $userProduct) {
            $subProducts = SubProduct::where('product_id', $userProduct->id)->get();
            $newSubProducts = $subProducts->map(function ($subProduct) {
                return ProductService::convertSubProduct($subProduct);
            });
            $userProduct->sub_products = $newSubProducts;
        }
        return $userProducts;
    }

    public static function updateSubProductQuantyByProductId($id)
    {
        $total = 0;
        $subProductsQuantity = Http::get('https://ltct-warehouse-backend.onrender.com/api/product/quantity/' . $id);
        $subProductsQuantity = $subProductsQuantity->json();
        foreach ($subProductsQuantity as $subProductQuantity) {
            $subProduct = SubProduct::find($subProductQuantity['itemId']);
            $subProduct->quantity = $subProductQuantity['goodQuantity'];
            $subProduct->save();
        }
        $subProducts = SubProduct::where('product_id', $id)->get();
        foreach ($subProducts as $subProduct) {
            $total += $subProduct->quantity;
        }
        return $total;
    }

    public static function updateCost()
    {
        $allPrices = Http::get("https://sp-17-production.fly.dev/api/v1/import/get-price?groupBy=product_id");
        foreach ($allPrices['data'] as $price) {
            $product = Product::find($price['product_id']);
            if (isset($price['price'])) {
                $product->cost = $price['price'];
                $product->save();
            }
        }
    }

    public static function updateSaleOff()
    {
        $allSaleOff = Http::get("https://team12-ads-app.fly.dev/api/products-sale-price");
        foreach ($allSaleOff['data'] as $saleOff) {
            $product = Product::find($saleOff['product_id']);
            if (isset($saleOff['sale_of'])) {
                $product->sale_off = $saleOff['sale_of'];
                $product->save();
            }
        }
    }
}