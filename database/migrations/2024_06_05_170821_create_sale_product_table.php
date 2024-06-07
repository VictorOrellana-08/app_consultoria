<?php

// database/migrations/xxxx_xx_xx_xxxxxx_create_sale_product_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaleProductTable extends Migration
{
    public function up()
    {
        Schema::create('sale_product', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sale_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->integer('quantity')->default(1); // Si quieres almacenar la cantidad de cada producto vendido
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sale_product');
    }
}
