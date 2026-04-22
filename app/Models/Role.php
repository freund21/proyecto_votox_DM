<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// PROYECTO + BASE LARAVEL:
// Modelo Eloquent creado para este proyecto para la tabla roles (ejemplo: admin, voter).
class Role extends Model
{
    // BASE LARAVEL + PROYECTO:
    // $fillable es de Laravel; name es el campo propio para identificar el rol.
    protected $fillable = ['name'];

    // PROYECTO:
    // Relacion: un rol puede tener muchos usuarios.
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
