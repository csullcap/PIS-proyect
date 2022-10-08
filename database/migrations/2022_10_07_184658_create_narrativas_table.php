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
			$table->integer('year');
			$table->string('semestre',255);
			$table->mediumText('cabecera');
			$table->mediumText('contenido');
			$table->foreignId('id_plan')
                  ->constrained('plans')
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
