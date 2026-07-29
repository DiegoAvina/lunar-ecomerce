<?php

namespace App\Http\Controllers;

use App\Services\Storefront\ProductService;
use Lunar\Models\Product;

class ProductController extends Controller
{
    public function __invoke(
        ProductService $products,
        Product $product,
    ) {
        return view('products.show', [
            'product' => $products->map($product),
        ]);
    }
}