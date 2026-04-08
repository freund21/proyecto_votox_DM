<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Migracion de categorias y tabla pivote categoria-subcategoria.
return new class extends Migration
{
    public function up(): void
    {
        // Cada categoria pertenece a una eleccion.
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('election_id')->constrained()->onDelete('cascade');
            $table->string('name');
            // Maximo de opciones que puede seleccionar un votante en esta categoria.
            $table->integer('max_selections')->default(1);
            $table->timestamps();
        });

        // Relacion many-to-many: que subcategorias pueden votar en cada categoria.
        Schema::create('category_subcategory', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->foreignId('subcategory_id')->constrained()->onDelete('cascade');
            $table->unique(['category_id', 'subcategory_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('category_subcategory');
        Schema::dropIfExists('categories');
    }
};
