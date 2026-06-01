<?php

namespace App\Services\Product;

use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class ProductService
{
    /**
     * Create a new product/service.
     */
    public function create(array $data, ?UploadedFile $thumbnail = null)
    {
        return DB::transaction(function () use ($data, $thumbnail) {
            $thumbnailPath = null;
            if ($thumbnail) {
                $thumbnailPath = $thumbnail->store('products', 'public');
            }

            return Product::create([
                'umkm_id' => $data['umkm_id'],
                'type' => $data['type'],
                'name' => $data['name'],
                'description' => $data['description'],
                'estimated_price' => $data['estimated_price'],
                'duration_minutes' => $data['duration_minutes'] ?? null,
                'thumbnail_url' => $thumbnailPath,
                'is_active' => $data['is_active'] ?? true,
            ]);
        });
    }

    /**
     * Update an existing product/service.
     */
    public function update(Product $product, array $data, ?UploadedFile $thumbnail = null)
    {
        return DB::transaction(function () use ($product, $data, $thumbnail) {
            $thumbnailPath = $product->thumbnail_url;
            if ($thumbnail) {
                // Delete old thumbnail if exists
                if ($thumbnailPath && Storage::disk('public')->exists($thumbnailPath)) {
                    Storage::disk('public')->delete($thumbnailPath);
                }
                $thumbnailPath = $thumbnail->store('products', 'public');
            }

            $product->update([
                'type' => $data['type'],
                'name' => $data['name'],
                'description' => $data['description'],
                'estimated_price' => $data['estimated_price'],
                'duration_minutes' => $data['duration_minutes'] ?? null,
                'thumbnail_url' => $thumbnailPath,
                'is_active' => $data['is_active'] ?? true,
            ]);

            return $product;
        });
    }

    /**
     * Delete a product/service.
     */
    public function delete(Product $product)
    {
        return DB::transaction(function () use ($product) {
            if ($product->thumbnail_url && Storage::disk('public')->exists($product->thumbnail_url)) {
                Storage::disk('public')->delete($product->thumbnail_url);
            }
            return $product->delete();
        });
    }
}
