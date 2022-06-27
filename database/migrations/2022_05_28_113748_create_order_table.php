<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order', function (Blueprint $table) {
            $table->id();
            $table->string('order_code', 255);
            $table->string('fullname', 50);
            $table->string('email', 255);
            $table->string('phone', 20);
            $table->string('address', 255);
            $table->text('note');
            $table->enum('payment', ['cod', 'online']);
            $table->timestamps();
            $table->enum('status', ['processing', 'cancelled', 'transported', 'successful']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order');
    }
}
