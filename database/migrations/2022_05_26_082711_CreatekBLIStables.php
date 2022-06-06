<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreatekBLIStables extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{

        echo "PATIENCE! this will take a while...\n";


		Schema::create('users', function(Blueprint $table)
        {
            $table->increments("id")->unsigned();
            $table->string("username", 50)->unique();
            $table->string("password", 100);
            $table->string("email", 100);
            $table->string("name", 100)->nullable();
            $table->tinyInteger("gender")->default(0);
            $table->string('phone_contact')->nullable();
            $table->string("designation", 100)->nullable();
            $table->string("image", 100)->nullable();
            $table->string("remember_token", 100)->nullable();
            $table->integer('facility_id')->unsigned()->nullable();

            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('tokens', function(Blueprint $table)
        {
            $table->string('email')->index();
            $table->string('token')->index();
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

        Schema::dropIfExists('tokens');
        Schema::dropIfExists('users');
        
	}
}
