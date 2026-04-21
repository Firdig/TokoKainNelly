<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

/**
 * Admin controller for managing fabric products and their variants.
 * Uses Form Request classes for validation and flushes catalog cache on mutations.
 */
class ProductController extends Controller
{
    /**
     * Display a listing of all products in admin panel.
     */
    public function index()
    {
        $products = Product::with('variants')->latest()->get();
        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new product.
     */
    public function create()
    {
        return view('admin.products.form');
    }

    /**
     * Store a newly created product with its variants and gallery images.
     * Validation is handled by StoreProductRequest.
     */
    public function store(StoreProductRequest $request)
    {
        $validated = $request->validated();
        $validated['branch_id'] = 1;

        $product = Product::create([
            'name'          => $validated['name'],
            'description'   => $validated['description'],
            'price'         => $validated['price'],
            'fabric_type'   => $validated['fabric_type'] ?? null,
            'texture'       => $validated['texture'] ?? null,
            'comfort_level' => $validated['comfort_level'] ?? null,
            'branch_id'     => $validated['branch_id'],
            'width'         => $validated['width'] ?? null,
            'composition'   => $validated['composition'] ?? null,
            'fabric_care'   => $validated['fabric_care'] ?? null,
        ]);

        // Store gallery images
        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $image) {
                $path = $image->store('products/gallery', 'public');
                $product->images()->create(['image_path' => $path]);
            }
        }

        // Create variants with optional images
        foreach ($request->variants as $variantData) {
            $imagePath = null;
            if (isset($variantData['image'])) {
                $imagePath = $variantData['image']->store('products', 'public');
            }

            $product->variants()->create([
                'color_name' => $variantData['color_name'],
                'hex_code'   => $variantData['hex_code'] ?? '#cccccc',
                'stock'      => $variantData['stock'],
                'image_path' => $imagePath,
            ]);
        }

        // Invalidate catalog cache
        Cache::forget('catalog_products');

        return redirect()->route('products.index')
            ->with('success', 'Produk kain beserta variasinya berhasil ditambahkan!');
    }

    /**
     * Show the form for editing an existing product.
     */
    public function edit(Product $product)
    {
        $product->load('variants', 'images');
        return view('admin.products.form', compact('product'));
    }

    /**
     * Update an existing product, its variants, and gallery images.
     * Validation is handled by UpdateProductRequest.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $validated = $request->validated();

        $product->update([
            'name'          => $validated['name'],
            'description'   => $validated['description'],
            'price'         => $validated['price'],
            'fabric_type'   => $validated['fabric_type'] ?? null,
            'texture'       => $validated['texture'] ?? null,
            'comfort_level' => $validated['comfort_level'] ?? null,
            'width'         => $validated['width'] ?? null,
            'composition'   => $validated['composition'] ?? null,
            'fabric_care'   => $validated['fabric_care'] ?? null,
        ]);

        // Add new gallery images
        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $image) {
                $path = $image->store('products/gallery', 'public');
                $product->images()->create(['image_path' => $path]);
            }
        }

        // Sync variants: update existing, create new, delete removed
        $existingVariantIds = [];

        foreach ($request->variants as $variantData) {
            $variant = null;

            if (!empty($variantData['id'])) {
                $variant = ProductVariant::find($variantData['id']);
                $existingVariantIds[] = $variant->id;
            }

            $imagePath = $variant ? $variant->image_path : null;
            if (isset($variantData['image'])) {
                if ($imagePath) {
                    Storage::disk('public')->delete($imagePath);
                }
                $imagePath = $variantData['image']->store('products', 'public');
            }

            if ($variant) {
                $variant->update([
                    'color_name' => $variantData['color_name'],
                    'hex_code'   => $variantData['hex_code'],
                    'stock'      => $variantData['stock'],
                    'image_path' => $imagePath,
                ]);
            } else {
                $newVariant = $product->variants()->create([
                    'color_name' => $variantData['color_name'],
                    'hex_code'   => $variantData['hex_code'],
                    'stock'      => $variantData['stock'],
                    'image_path' => $imagePath,
                ]);
                $existingVariantIds[] = $newVariant->id;
            }
        }

        // Remove variants that were deleted from the form
        $variantsToDelete = $product->variants()
            ->whereNotIn('id', $existingVariantIds)->get();
        foreach ($variantsToDelete as $varDelete) {
            if ($varDelete->image_path) {
                Storage::disk('public')->delete($varDelete->image_path);
            }
            $varDelete->delete();
        }

        // Invalidate catalog cache
        Cache::forget('catalog_products');

        return redirect()->route('products.index')
            ->with('success', 'Produk kain berhasil diperbarui!');
    }

    /**
     * Delete a product and all its associated variants and images.
     */
    public function destroy(Product $product)
    {
        foreach ($product->variants as $variant) {
            if ($variant->image_path) {
                Storage::disk('public')->delete($variant->image_path);
            }
        }
        foreach ($product->images as $img) {
            if ($img->image_path) {
                Storage::disk('public')->delete($img->image_path);
            }
        }
        $product->delete();

        // Invalidate catalog cache
        Cache::forget('catalog_products');

        return redirect()->route('products.index')
            ->with('success', 'Produk kain berhasil dihapus!');
    }
}
