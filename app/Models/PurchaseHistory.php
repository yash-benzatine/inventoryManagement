<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class PurchaseHistory extends Model
{
    use HasFactory;

    public function Product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function Purchase(): BelongsTo
    {
        return $this->belongsTo(Purchase::class, 'purchase_code', 'id');
    }
}
