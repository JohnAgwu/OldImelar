<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBusinessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('businesses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->enum('mode', ['BUY_SELL', 'FREELANCE']);
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->longText('social')->nullable();
            $table->text('address')->nullable();
            $table->string('lga')->nullable();
            $table->string('state')->nullable();
            $table->string('country');
            $table->longText('description')->nullable();
            $table->string('category');
            $table->string('sub_category')->nullable();
            $table->enum('type', ['WHOLESALER', 'RETAILER', 'BOTH'])->nullable();
            $table->text('logo')->nullable();
            $table->text('cover')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('businesses');
    }
}
