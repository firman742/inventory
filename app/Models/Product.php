<?php

namespace App\Models;

use App\Enums\Table;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasUuids, HasFactory;

    protected $table = Table::products->name;

    protected $fillable = [
        'sku',
        'name',
        'product_type_id',
        'default_price',
        'description',
    ];

    /**
     *
     * @return BelongsTo
     */
    public function productType(): BelongsTo
    {
        return $this->belongsTo(ProductType::class);
    }
}
