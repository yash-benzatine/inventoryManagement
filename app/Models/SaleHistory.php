<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use App\Models\Product;

class SaleHistory extends Model
{
    use HasFactory;

    public function Product(): belongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function Sale(): BelongsTo
    {
        return $this->belongsTo(Sale::class, 'invoice_code', 'id');
    }
}
