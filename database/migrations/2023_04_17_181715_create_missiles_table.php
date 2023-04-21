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
        Schema::create('missiles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('partie_id');
            $table->boolean('coup_joueur');
            $table->string('coordonnee');
            $table->integer('resultat');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('missiles');
    }
};
