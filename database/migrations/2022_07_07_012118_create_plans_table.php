<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('codigo', 11);
            $table->string('name');
            $table->string('oportunidad');
            $table->string('semestre', 6);
            $table->integer('duracion');
            $table->string('estado', 20);
            $table->boolean('eficacia');
            $table->foreignId('id_estandar')
                  ->constrained('estandars');
            $table->foreignId('id_user')
                  ->constrained('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plans');
    }
};
