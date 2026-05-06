<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('documents', function (Blueprint $table) {
            // total_points can be up to 960+ per document, tinyInt (max 255) is too small
            $table->unsignedSmallInteger('total_points')->nullable()->change();
            // vori/ana/roti/point raw inputs — keep tinyInt but allow larger vori
            $table->unsignedSmallInteger('vori')->default(0)->change();
            $table->unsignedSmallInteger('total_vori')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('documents', function (Blueprint $table) {
            $table->unsignedTinyInteger('total_points')->nullable()->change();
            $table->unsignedTinyInteger('vori')->default(0)->change();
            $table->unsignedTinyInteger('total_vori')->nullable()->change();
        });
    }
};
