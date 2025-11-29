<?php

use App\Enums\Table;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(Table::products->name, function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->string('sku')->unique();
            $table->string('name');
            $table->uuid('product_type_id');
            $table->decimal('default_price',12,2)->nullable();
            $table->text('description')->nullable();

            $table->foreign('product_type_id')->references('id')->on(Table::product_types->name)->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(Table::products->name);
    }
};
