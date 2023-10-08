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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->json('images')->nullable();
            $table->integer('category')->unsigned();
            $table->integer('user')->unsigned();
            $table->foreign('category')->references('id')->on('categories');
            $table->foreign('user')->references('id')->on('users');
            $table->integer('totalRating')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
