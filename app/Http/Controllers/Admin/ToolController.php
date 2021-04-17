<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Jobs\UpdateProductPrice;

class ToolController extends Controller
{
    public function updateProductPrice()
    {
        $products = Product::all();

        foreach($products as $product) {
            UpdateProductPrice::dispatch($product)->onQueue('tool');
        }
    }
}
