<?php

use App\Enums\SourceSerial;
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
        Schema::create(Table::serials->name, function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('product_id');
            $table->uuid('stock_in_batch_id');
            $table->uuid('added_by');
            $table->string('serial_number')->unique();
            $table->enum('status', ['in_stock','out','lost'])->default('in_stock');
            $table->string('location')->nullable();
            $table->decimal('unit_price',12,2)->nullable();
            // Kolom baru
            $table->enum('source', SourceSerial::values())->default(SourceSerial::MANUAL->value); // Menyimpan sumber input serial
            $table->string('scan_format')->nullable(); // Untuk menyimpan format dari ZXing-js, e.g., 'EAN_13', 'QR_CODE'

            $table->foreign('product_id')->references('id')->on(Table::products->name)->onDelete('cascade');
            $table->foreign('stock_in_batch_id')->references('id')->on(Table::stock_in_batches->name)->onDelete('cascade');
            $table->foreign('added_by')->references('id')->on(Table::users->name)->onDelete('cascade');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(Table::serials->name);
    }
};
