<?php

namespace App\Models;

use App\Enums\Table;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StockInBatch extends Model
{
    use HasUuids, HasFactory;

    protected $table = Table::stock_in_batches->name;

    protected $fillable = [
        'reference',
        'source',
        'received_by',
        'in_items',
        'out_items',
        'remaining_items',
        'original_price',
    ];

    /**
     * @return HasMany
     */
    public function serials(): HasMany
    {
        return $this->hasMany(Serial::class, 'stock_in_batch_id');
    }

    /**
     * @return BelongsTo
     */
    public function receiver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'received_by');
    }
}
