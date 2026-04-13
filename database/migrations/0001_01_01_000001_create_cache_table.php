<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Migracion base de Laravel para sistema de cache en BD.
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Tabla principal de entradas de cache.
        Schema::create('cache', function (Blueprint $table) {
            $table->string('key')->primary();
            $table->mediumText('value');
            $table->integer('expiration')->index();
        });

        // Bloqueos para operaciones atomicas de cache.
        Schema::create('cache_locks', function (Blueprint $table) {
            $table->string('key')->primary();
            $table->string('owner');
            $table->integer('expiration')->index();
        });
    }

    /**
     * deshace las  migrationes.(borra las tablas)
     */
    public function down(): void
    {
        // Revierte ambas tablas de cache.
        Schema::dropIfExists('cache');
        Schema::dropIfExists('cache_locks');
    }
};
