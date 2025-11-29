<?php

namespace App\Models;

use App\Enums\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StockOut extends Model
{
    use HasUuids, HasFactory;

    protected $table = Table::stock_outs->name;

    protected $fillable = [
        'reference',
        'processed_by',
        'total_items',
        'total_value',
    ];

    /**
     * @return BelongsTo
     */
    public function processor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'processed_by');
    }


}
