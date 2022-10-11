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
        Schema::create('narrativas', function (Blueprint $table) {
            $table->id();
            $table->string('semestre', 255);
            $table->mediumText('contenido');
            $table->foreignId('id_estandar')
                ->constrained('estandars')
                ->onDelete('cascade');
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
        Schema::dropIfExists('narrativas');
    }
};
