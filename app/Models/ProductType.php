<?php

namespace App\Models;

use App\Enums\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductType extends Model
{
    use HasUuids, HasFactory;
    
    protected $table = Table::product_types->name;

    protected $fillable = [
        'name',
        'description',
        'is_active',
    ];

    /**
     * @return HasMany
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
