<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->bigIncrements('id');
            $table->unsignedBigInteger('business_id');
            $table->string('name');
            $table->integer('size');
            $table->string('unit');
            $table->integer('quantity');
            $table->string('payment_status');
//            $table->double('unit_price', 100, 2);
            $table->double('total_purchase_price', 100, 2);
            $table->double('amount_paid', 100, 2)->nullable();
            $table->double('purchase_expenses', 100, 2)->nullable();
            $table->longText('expenses')->nullable();
//            $table->string('cost_inbound')->nullable();
            $table->double('min_selling_price', 100, 2)->nullable();
            $table->double('max_selling_price', 100, 2)->nullable();
            $table->longText('description')->nullable();
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
        Schema::dropIfExists('products');
    }
}
