<?php

namespace App\Models;

use App\Enums\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductType extends Model
{
    use HasUuids, HasFactory;
    
    protected $table = Table::product_types->name;

    protected $fillable = [
        'name',
        'description',
        'is_active',
    ];
}
