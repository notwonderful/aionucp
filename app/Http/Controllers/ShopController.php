<?php

namespace App\Http\Controllers;

use App\Actions\GetProductData;
use App\Models\Product;
use Illuminate\View\View;

class ShopController extends Controller
{
    public function index(GetProductData $getShopData): View
    {
        $products = $getShopData->execute();

        return view('pages.shop.create', compact('products'));
    }

    public function show(Product $product)
    {
        return view('pages.shop.show', compact('product'));
    }
}
