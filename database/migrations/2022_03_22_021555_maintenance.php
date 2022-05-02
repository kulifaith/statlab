<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Maintenance extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('maintenance', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('house_id')->nullable();
            $table->integer('site_id');
            $table->string('area')->nullable();
            $table->string('amount_used')->nullable();
            $table->string('contractor')->nullable();
            $table->string('contractor_contact')->nullable();
            $table->string('contractor_description')->nullable();
            $table->string('payment_method');
            $table->date('date_from')->nullable();
            $table->date('date_to')->nullable();
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
        Schema::dropIfExists('maintenance');
    }
}
