<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Migracion de subcategorias y relacion usuario-subcategoria.
return new class extends Migration
{
    public function up(): void
    {
        // Subcategorias de votantes (ejemplo: profesorado, alumnado...).
        Schema::create('subcategories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });

        // Tabla pivote many-to-many entre users y subcategories.
        Schema::create('subcategory_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('subcategory_id')->constrained()->onDelete('cascade');
            // Evita repetir la misma pareja usuario-subcategoria.
            $table->unique(['user_id', 'subcategory_id']);
        });
    }

    public function down(): void
    {
        // Se borra primero la pivote y luego la tabla principal.
        Schema::dropIfExists('subcategory_user');
        Schema::dropIfExists('subcategories');
    }
};
