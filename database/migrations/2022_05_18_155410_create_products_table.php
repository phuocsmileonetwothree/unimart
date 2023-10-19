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
            $table->string('name', 255);

            $table->string('slug', 255)->nullable();
            $table->integer('price')->nullable();
            $table->integer('old_price')->nullable();
            $table->string('desc', 500)->nullable();
            $table->text('content')->nullable();
            $table->bigInteger('cat_id');
            $table->bigInteger('brand_id');
            $table->bigInteger('ram_id');
            $table->bigInteger('memory_id');
            $table->enum('status', ['on', 'off']);
            $table->enum('stocking', ['still', 'out']);
            $table->unsignedBigInteger('user_id')->default(1);


            $table->softDeletes();
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
