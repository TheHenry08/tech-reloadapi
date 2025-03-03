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
        Schema::create('producto', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('descripcion');
            $table->boolean('oferta')->default(false);
            $table->decimal('precio',8,2);
            $table->decimal('precio_oferta', 8, 2)->storedAs('CASE WHEN oferta = 1 THEN precio * 0.9 ELSE precio END');

            //$table->decimal('precio_oferta',8,2)->storedAs('CASE WHEN oferta THEN precio * 0.9 ELSE precio END');
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
        Schema::dropIfExists('producto');
    }
};
