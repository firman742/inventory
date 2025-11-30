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
        Schema::create(Table::stock_in_batches->name, function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('reference')->nullable();
            $table->string('source')->nullable();
            $table->uuid('received_by');
            $table->integer('in_items')->default(0); // total item yang masuk di batch ini
            $table->integer('out_items')->default(0);  // item yang keluar dari batch ini
            $table->integer('remaining_items')->default(0); // item yang tersisa di batch ini
            $table->decimal('original_price',14,2)->default(0);

            $table->foreign('received_by')->references('id')->on(Table::users->name)->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(Table::stock_in_batches->name);
    }
};
