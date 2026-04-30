<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    protected $fillable = ['product_id', 'image_data', 'image_mime'];

    /**
     * Get the URL to serve the gallery image.
     */
    public function getImageUrlAttribute()
    {
        if ($this->image_data) {
            return route('image.gallery', $this->id);
        }
        return null;
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
