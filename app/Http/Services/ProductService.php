<?php

namespace App\Http\Services;

use App\Models\SubProduct;
use App\Models\Product;
use App\Models\Color;
use App\Models\Size;
use App\Models\Category;

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
}