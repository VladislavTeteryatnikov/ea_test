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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();

            $table->string('g_number');
            $table->date('date');
            $table->dateTime('last_change_date');
            $table->string('supplier_article');
            $table->string('tech_size');
            $table->string('barcode');
            $table->decimal('total_price', total: 10, places: 5);
            $table->double('discount_percent');
            $table->boolean('is_supply');
            $table->boolean('is_realization');
            $table->double('promo_code_discount')->nullable();
            $table->string('warehouse_name');
            $table->string('country_name');
            $table->string('oblast_okrug_name');
            $table->string('region_name');
            $table->integer('income_id')->nullable();
            $table->string('sale_id');
            $table->integer('odid')->nullable();
            $table->double('spp');
            $table->decimal('for_pay', total: 10, places: 2);
            $table->decimal('finished_price', total: 10, places: 2);
            $table->decimal('price_with_disc', total: 10, places: 2);
            $table->integer('nm_id');
            $table->string('subject');
            $table->string('category');
            $table->string('brand');
            $table->integer('is_storno')->nullable();


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
