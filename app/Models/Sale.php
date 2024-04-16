<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Customer;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\hasMany;
use App\Models\SaleHistory;

class Sale extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Get the user that owns the Sale
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer', 'id');
    }

    public function products()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function SaleHistory() : hasMany
    {
        return $this->hasMany(SaleHistory::class, 'invoice_code', 'invoice_code');
    }
}
