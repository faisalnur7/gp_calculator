<?php

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
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shop_id')->constrained('shops')->cascadeOnDelete();
            $table->foreignId('jewellery_item_id')->constrained('jewellery_items')->cascadeOnDelete();
            $table->date('document_date')->nullable();
            $table->string('reference_number')->nullable();
            $table->unsignedTinyInteger('vori')->default(0);
            $table->unsignedTinyInteger('ana')->default(0);
            $table->unsignedTinyInteger('roti')->default(0);
            $table->unsignedTinyInteger('point')->default(0);
            $table->unsignedTinyInteger('total_vori')->nullable();
            $table->unsignedTinyInteger('total_ana')->nullable();
            $table->unsignedTinyInteger('total_roti')->nullable();
            $table->unsignedTinyInteger('total_points')->nullable();
            $table->decimal('total_grams', 12, 4)->nullable();
            $table->decimal('unit_price_per_gram', 14, 4)->nullable();
            $table->decimal('subtotal', 16, 4)->nullable();
            $table->text('notes')->nullable();
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
