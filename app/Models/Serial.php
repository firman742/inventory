<?php

namespace App\Models;

use App\Enums\Table;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Serial extends Model
{
    use HasUuids, HasFactory;

    protected $table = Table::serials->name;

    protected $fillable = [
        'serial_number',
        'product_id',
        'stock_in_batch_id',
        'status',
        'location',
        'unit_price',
        'source',
        'scan_format',
        'added_by',
    ];

    /**
     * @return BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    /**
     * @return BelongsTo
     */
    public function stockInBatch(): BelongsTo
    {
        return $this->belongsTo(StockInBatch::class, 'stock_in_batch_id');
    }

    /**
     * @return BelongsTo
     */
    public function addedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'added_by');
    }

}
