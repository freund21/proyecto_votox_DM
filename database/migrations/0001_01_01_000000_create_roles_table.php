<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Migracion Laravel:
// crea la tabla roles (ejemplo: admin, voter).
return new class extends Migration
{
    public function up(): void
    {
        // up() se ejecuta al correr "php artisan migrate".
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        // down() revierte la migracion.
        Schema::dropIfExists('roles');
    }
};
