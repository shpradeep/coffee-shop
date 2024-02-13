<?php

namespace App\Http\Controllers;

use App\Models\ProductDetails;
use Illuminate\Http\Request;

class ProductDetailsController extends Controller
{
    /**
     * Show the product details for given product.
     */
    public function show(string $id)
    {
        return ProductDetails::findOrFail($id);
    }
}
