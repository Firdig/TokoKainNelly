<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\Cache;

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
                $product->images()->create([
                    'image_data' => base64_encode(file_get_contents($image->getRealPath())),
                    'image_mime' => $image->getMimeType(),
                ]);
            }
        }

        // Create variants with optional images
        foreach ($request->variants as $variantData) {
            $imageData = null;
            $imageMime = null;
            if (isset($variantData['image'])) {
                $imageData = base64_encode(file_get_contents($variantData['image']->getRealPath()));
                $imageMime = $variantData['image']->getMimeType();
            }

            $product->variants()->create([
                'color_name' => $variantData['color_name'],
                'hex_code'   => $variantData['hex_code'] ?? '#cccccc',
                'stock'      => $variantData['stock'],
                'image_data' => $imageData,
                'image_mime' => $imageMime,
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
                $product->images()->create([
                    'image_data' => base64_encode(file_get_contents($image->getRealPath())),
                    'image_mime' => $image->getMimeType(),
                ]);
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

            $imageData = $variant ? $variant->image_data : null;
            $imageMime = $variant ? $variant->image_mime : null;
            if (isset($variantData['image'])) {
                $imageData = base64_encode(file_get_contents($variantData['image']->getRealPath()));
                $imageMime = $variantData['image']->getMimeType();
            }

            if ($variant) {
                $variant->update([
                    'color_name' => $variantData['color_name'],
                    'hex_code'   => $variantData['hex_code'],
                    'stock'      => $variantData['stock'],
                    'image_data' => $imageData,
                    'image_mime' => $imageMime,
                ]);
            } else {
                $newVariant = $product->variants()->create([
                    'color_name' => $variantData['color_name'],
                    'hex_code'   => $variantData['hex_code'],
                    'stock'      => $variantData['stock'],
                    'image_data' => $imageData,
                    'image_mime' => $imageMime,
                ]);
                $existingVariantIds[] = $newVariant->id;
            }
        }

        // Remove variants that were deleted from the form
        $variantsToDelete = $product->variants()
            ->whereNotIn('id', $existingVariantIds)->get();
        foreach ($variantsToDelete as $varDelete) {
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
        $product->delete();

        // Invalidate catalog cache
        Cache::forget('catalog_products');

        return redirect()->route('products.index')
            ->with('success', 'Produk kain berhasil dihapus!');
    }
}
