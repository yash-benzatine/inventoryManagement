<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // Add this line
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\hasMany; // Add this line

class Product extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Get the user that owns the Product
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }


    /**
     * The Sale that belong to the Product
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function Sale(): hasMany
    {
        return $this->hasMany(Sale::class);
    }

    public function SubCategory(): hasMany
    {
        return $this->hasMany(Category::class, 'cat_id', 'category_id');
    }
}
