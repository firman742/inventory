<?php

use App\Enums\Table;
use App\Enums\TypeTransaction;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Nette\Utils\Type;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(Table::transactions->name, function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->enum('type', TypeTransaction::values());
            $table->uuid('serial_id');
            $table->uuid('product_id');
            $table->uuid('user_id');
            $table->integer('qty')->default(1);
            $table->decimal('price',12,2)->nullable();
            $table->text('note')->nullable();

            $table->foreign('serial_id')->references('id')->on(Table::serials->name)->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on(Table::products->name)->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on(Table::users->name)->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(Table::transactions->name);
    }
};
