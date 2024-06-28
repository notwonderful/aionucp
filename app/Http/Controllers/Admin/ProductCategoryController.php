<?php

namespace App\Http\Controllers\Admin;

use App\Actions\GetProductCategory;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductCategoryRequest;
use App\Models\ProductCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

final class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(GetProductCategory $getProductCategory): View
    {
        $categories = $getProductCategory->execute();

        return view('pages.admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(GetProductCategory $categories): View
    {
        return view('pages.admin.categories.form', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductCategoryRequest $request): RedirectResponse
    {
        ProductCategory::create($request->validated());

        return redirect()->route('categories.index')->with('success', 'The product category has been successfully created!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductCategory $category): View
    {
        return view('pages.admin.categories.form', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductCategoryRequest $request, ProductCategory $category): RedirectResponse
    {
        $category->update($request->validated());

        return back()->with('success', 'The product category has been successfully updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductCategory $category): RedirectResponse
    {
        $category->delete();

        return back()->with('success', 'The product category has been successfully deleted!');
    }
}
