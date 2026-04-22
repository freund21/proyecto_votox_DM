<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// PROYECTO + BASE LARAVEL:
// Modelo Eloquent creado para este proyecto para la tabla subcategories.
// Se usa para controlar que tipo de usuario puede votar en cada categoria.
class Subcategory extends Model
{
    // BASE LARAVEL + PROYECTO:
    // $fillable es de Laravel; name es el campo propio del proyecto.
    protected $fillable = ['name'];

    // PROYECTO:
    // Relacion muchos a muchos con usuarios.
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    // PROYECTO:
    // Relacion muchos a muchos con categorias.
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
}
