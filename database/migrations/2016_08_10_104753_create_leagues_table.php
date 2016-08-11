<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeaguesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leagues', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('adress_id')->unsigned()->unique();
            $table->integer('contact_id')->unsigned()->unique();
            $table->string('name');
            $table->string('logo');
            $table->string('description')->nullable();
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
        Schema::drop('leagues');
    }
}
