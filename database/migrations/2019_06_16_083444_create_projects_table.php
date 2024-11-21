<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('business_id');
            $table->string('title');
            $table->string('payment_status');
            $table->enum('status', ['In Progress', 'Completed']);
            $table->double('price', 100, 2)->nullable();
            $table->double('amount_paid', 100, 2)->nullable();
            $table->double('project_expenses', 100, 2)->nullable();
            $table->longText('expenses')->nullable();
            $table->longText('description')->nullable();
            $table->date('end_date');
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
        Schema::dropIfExists('projects');
    }
}
