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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("image")->nullable();
            $table->string("brand");
            $table->string("category");
            $table->text("description")->nullable();
            $table->decimal("price", 8, 2);
            $table->tinyInteger("discount")->default(0);
            $table->decimal("price_sale", 8, 2);
            $table->integer("stock");

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
