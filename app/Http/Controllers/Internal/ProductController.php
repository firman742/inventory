<?php

namespace App\Http\Controllers\Internal;

use App\Models\Product;
use App\Models\ProductType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all()->load('productType');

        return view("Internal.Products.index", compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $productTypes = ProductType::all();
        return view("Internal.Products.create", compact('productTypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'sku' => 'required|unique:products,sku',
            'name' => 'required|string|max:255',
            'product_type_id' => 'required|exists:product_types,id',
            'default_price' => 'nullable|numeric',
            'description' => 'nullable|string',
        ]);

        Product::create($validated);

        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $productTypes = ProductType::all();
        $product->load('productType');
        
        return view("Internal.Products.edit", compact(['product', 'productTypes']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'sku' => 'required|unique:products,sku,' . $product->id,
            'name' => 'required|string|max:255',
            'product_type_id' => 'required|exists:product_types,id',
            'default_price' => 'nullable|numeric',
            'description' => 'nullable|string',
        ]);

        $product->update($validated);

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }
}
