<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jewellery_items', function (Blueprint $table) {
            $table->id();
            $table->string('item_name');
            $table->foreignId('category_id')->nullable()->constrained('jewellery_categories')->nullOnDelete();
            $table->foreignId('shop_id')->nullable()->constrained('shops')->nullOnDelete();
            $table->string('reference')->nullable();
            $table->string('gold_type')->default('22K');
            $table->date('purchase_date')->nullable();

            // Weight input
            $table->unsignedSmallInteger('weight')->default(0); // raw weight in points or descriptive
            $table->decimal('subtotal', 16, 4)->nullable();
            $table->decimal('price', 16, 4)->nullable();

            $table->unsignedSmallInteger('vori')->default(0);
            $table->unsignedTinyInteger('ana')->default(0);
            $table->unsignedTinyInteger('roti')->default(0);
            $table->unsignedTinyInteger('points')->default(0);

            // Computed weight totals
            $table->unsignedSmallInteger('total_vori')->nullable();
            $table->unsignedTinyInteger('total_ana')->nullable();
            $table->unsignedTinyInteger('total_roti')->nullable();
            $table->unsignedSmallInteger('total_points')->nullable();
            $table->decimal('total_grams', 12, 4)->nullable();

            // Pricing
            $table->decimal('unit_price_per_gram', 14, 4)->nullable();

            // Photos
            $table->string('document_photo')->nullable();
            $table->string('item_photo')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jewellery_items');
    }
};
