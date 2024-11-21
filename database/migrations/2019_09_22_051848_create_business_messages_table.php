<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBusinessMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('business_messages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('business_id');
            $table->enum('type', ['HOLIDAY', 'BIRTHDAY', 'NEW_ITEM_ALERT']);
            $table->enum('channel', ['EMAIL', 'SMS', 'WHATSAPP'])->default('EMAIL');
            $table->string('message', 140);
            $table->timestamps();


            $table->foreign('business_id')
                ->references('id')->on('businesses')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('business_messages');
    }
}
