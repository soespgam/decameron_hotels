<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('hotels', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('city');
            $table->string('address');
            $table->integer('capacity');
            $table->string('nit')->unique();
            $table->integer('estandar');
            $table->integer('junior');
            $table->integer('suite');
            $table->integer('ava_estandar');
            $table->integer('ava_junior');
            $table->integer('ava_suite');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hotels');
    }
};
