<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Migracion de usuarios y sesiones.
// users: datos de login y perfil.
// sessions: sesiones activas de Laravel.
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('dni')->unique();
            $table->string('username')->unique();
            $table->string('full_name');
            $table->string('email')->unique();
            $table->string('password');
            // Relacion con roles.id; por defecto 2 (votante en este proyecto).
            $table->foreignId('role_id')->constrained('roles')->default(2);
            $table->rememberToken();
            $table->timestamps();
        });

        // Tabla de sesiones para mantener login entre peticiones.
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    public function down(): void
    {
        // Orden inverso por dependencia.
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('users');
    }
};
