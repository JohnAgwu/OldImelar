<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('business_id');
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->unsignedBigInteger('debit_card_id')->nullable();
            $table->string('payment_status');
            $table->string('payment_method')->nullable();
            $table->enum('payment_option', ['AUTOMATIC', 'MANUAL'])->default('MANUAL');
            $table->dateTime('payment_date')->nullable();
            $table->double('amount_paid', 100, 2)->nullable();
            $table->double('amount_unpaid', 100, 2)->nullable();
            $table->dateTime('payment_due_date')->nullable();
            $table->enum('sending_channel', ['EMAIL', 'SMS', 'WHATSAPP'])->default('EMAIL');
            $table->double('expenses_incurred', 100, 2)->nullable();
            $table->longText('expenses')->nullable();
            $table->timestamp('dispatched_at')->nullable();
            $table->boolean('completed')->default(false);
            $table->timestamps();
            $table->softDeletes();


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
        Schema::dropIfExists('invoices');
    }
}
