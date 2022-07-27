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
        Schema::create('responsables_planes_mejoras', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('id_plan')
                  ->constrained('plans')
                  ->onDelete('cascade');
            $table->foreignId('id_responsable')
                  ->constrained('responsables');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('responsables_planes_mejoras');
    }
};
