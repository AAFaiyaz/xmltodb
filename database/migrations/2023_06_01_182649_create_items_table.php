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
        Schema::create('items', function (Blueprint $table) {
           $table->string('entity_id');
        $table->string('CategoryName');
        $table->string('sku');
        $table->string('name');
        $table->text('description')->nullable();
        $table->text('shortdesc');
        $table->decimal('price', 8, 2);
        $table->string('link');
        $table->string('image');
        $table->string('Brand');
        $table->integer('Rating');
        $table->string('CaffeineType')->nullable();
        $table->integer('Count')->nullable();
        $table->string('Flavored')->nullable();
        $table->string('Seasonal')->nullable();
        $table->string('Instock');
        $table->integer('Facebook');
        $table->integer('IsKCup');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
