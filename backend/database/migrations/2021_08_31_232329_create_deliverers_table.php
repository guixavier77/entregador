<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliverersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deliverers', function (Blueprint $table) {
            $table->id();
            $table->string('cpf')->unique();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('image');
            $table->string('cnh_image');
            $table->string('phone');
            $table->string('password');
            $table->string('remember_token')->nullable();
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
        Schema::dropIfExists('deliverers');
    }
}
