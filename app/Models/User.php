<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

// Modelo Eloquent de Laravel para tabla users.
// Eloquent = capa ORM: trabajar con filas de BD como objetos PHP.
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // Campos permitidos para create()/update() masivos.
    protected $fillable = [
        'dni',
        'username',
        'full_name',
        'email',
        'password',
        'role_id',
    ];

    // Campos que no se exponen al serializar el modelo.
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Conversores automaticos de Laravel.
    // password => hashed: al guardar, Laravel aplica hash (convierte el dato)automaticamente.
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    // Relacion: un usuario pertenece a un rol.
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    // Relacion muchos a muchos con subcategorias.
    public function subcategories()
    {
        return $this->belongsToMany(Subcategory::class);
    }

    // Relacion: un usuario tiene muchos votos.
    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

    // Logica de negocio propia del proyecto.
    public function isAdmin(): bool
    {
        return $this->role->name === 'admin';
    }

    // Comprueba si este usuario ya voto en una categoria.
    public function hasVotedInCategory(int $categoryId): bool
    {
        return $this->votes()->where('category_id', $categoryId)->exists();
    }
}
