<?php

namespace App\Http\Controllers\Internal;

use App\Models\ProductType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $productTypes = ProductType::all();
        return view("Internal.ProductTypes.index", compact('productTypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("Internal.ProductTypes.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $validated['is_active'] = true;
        ProductType::create($validated);

        return redirect()->route('product-types.index')->with('success', 'Product Type created successfully.');
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductType $productType)
    {
        return view("Internal.ProductTypes.edit", compact('productType'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductType $productType)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'required|boolean',
        ]);

        $productType->update($validated);

        return redirect()->route('product-types.index')->with('success', 'Product Type updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductType $productType)
    {
        $productType->delete();
        
        return redirect()->route('product-types.index')->with('success', 'Product Type deleted successfully.');
    }
}
