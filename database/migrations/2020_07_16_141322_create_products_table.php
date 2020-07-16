<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type')->default('service');
            $table->decimal('price', 11, 2);
            $table->unsignedInteger('limit')->default(1);
            $table->unsignedInteger('offer')->default(1);
            $table->decimal('postage', 11, 2)->nullable();
            $table->boolean('is_dispatchable')->default(0);
            $table->decimal('duration', 11, 1)->default(1);
            $table->boolean('email')->default(0);
            $table->string('permission')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
