<?php

namespace App\Http\Controllers\Admin;

use App\Actions\GetProductData;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductRequest;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

final class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(GetProductData $getProductCategory): View
    {
        $products = $getProductCategory->execute();

        return view('pages.admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(GetProductData $products): View
    {
        return view('pages.admin.products.form', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();

        if($request->hasFile('image')) {
            $validatedData['image'] = $request->image->store('images/products', 'public');
        }

        Product::create($validatedData);

        return redirect()->back()->with('success', __('The product has been successfully created!'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product): View
    {
        return view('pages.admin.products.form', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, Product $product): RedirectResponse
    {
        $product->update($request->validated());

        return back()->with('success', 'The product has been successfully updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();

        return back()->with('success', 'The product has been successfully deleted!');
    }
}
