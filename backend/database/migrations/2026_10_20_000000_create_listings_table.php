<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('listings', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('name');
            $table->text('description');
            $table->string('category', 50);
            $table->string('size', 30);
            $table->string('condition', 100);
            $table->string('color');
            $table->string('material');
            $table->json('measurements');
            $table->char('currency', 3);
            $table->unsignedInteger('price_minor');
            $table->string('availability', 20);
            $table->json('photos');
            $table->json('model');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('listings');
    }
};
