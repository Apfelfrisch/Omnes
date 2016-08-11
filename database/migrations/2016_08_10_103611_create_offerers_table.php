<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOfferersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offerers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('adress_id')->unsigned()->unique();
            $table->integer('contact_id')->unsigned()->unique();
            $table->string('name');
            $table->string('logo')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
            $table->foreign('adress_id')
                ->references('id')
                ->on('adresses')
                ->onDelete('cascade');
            $table->foreign('contact_id')
                ->references('id')
                ->on('contacts')
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
        Schema::drop('offerers');
    }
}
