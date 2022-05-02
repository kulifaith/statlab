<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class House extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('house', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('house_no')->nullable();
            $table->integer('category_id');
            $table->integer('site_id');
            $table->string('description')->nullable();
            $table->integer('price')->nullable();
            $table->integer('available')->default(0);
            $table->integer('created_by');
            $table->integer('updated_by');
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
        Schema::dropIfExists('house');
    }
}
