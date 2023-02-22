<?php

namespace App\Http\Services;

use App\Models\SubProduct;
use App\Models\Product;
use App\Models\Color;
use App\Models\Size;
use Illuminate\Support\Facades\Http;

class ProductService
{
    public static function createSubProduct($subProducts, $productId)
    {
        foreach ($subProducts as $colorId => $subProduct) {
            foreach ($subProduct as $subProductItem) {
                $subProductExist = SubProduct::where('product_id', $productId)
                    ->where('color_id', $colorId)
                    ->where('size_id', $subProductItem['size_id'])
                    ->first();
                if ($subProductExist) {
                    $subProductExist->quantity = $subProductItem['quantity'];
                    $subProductExist->image_url = $subProductItem['image_url'];
                    $subProductExist->save();
                } else {
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
        try {
            $subProductsQuantity = Http::get(env('SUB_PRODUCT_API_URL') . $id);
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
        } catch (\Throwable $th) {
            return $total;
        }
    }

    public static function updateCost($id)
    {
        $allItems = Http::get(env("PRODUCT_COTS_API_URL"));
        foreach ($allItems['data'] as $item) {
            if ($item['product_id'] == $id) {
                $product = Product::find($item['product_id']);
                $product->cost = $item['price'];
                $product->save();
            }
        }
    }

    public static function updateSaleOff($id)
    {
        $allSaleOff = Http::get(env("PRODUCT_SALE_OFF_API_URL"));
        foreach ($allSaleOff['data'] as $saleOff) {
            if ($saleOff['product_id'] == $id) {
                $product = Product::find($saleOff['product_id']);
                $product->sale_off = $saleOff['sale_of'];
                $product->save();
            }
        }
    }
}
