<?php

namespace App\Http\Controllers;

use App\Models\ProductDetails;
use Illuminate\Http\Request;

class ProductDetailsController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ProductDetails::all();
    }

    /**
     * Show the product details for given product.
     */
    public function show(string $id)
    {
        return ProductDetails::findOrFail($id);
    }
}
