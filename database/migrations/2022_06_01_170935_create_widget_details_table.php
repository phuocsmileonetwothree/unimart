<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWidgetDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('widget_details', function (Blueprint $table) {
            $table->id();
            $table->string('value', 255);
            $table->string('url', 270)->nullable();
            $table->integer('order');
            $table->timestamps();
            $table->foreignId('widget_id')->constrained('widgets');
            $table->foreignId('detail_id')->nullable()->constrained('widget_details')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('widget_details');
    }
}
