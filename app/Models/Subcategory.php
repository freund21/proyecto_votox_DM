<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Modelo Eloquent para tabla subcategories.
// Se usa para controlar que tipo de usuario puede votar en cada categoria.
class Subcategory extends Model
{
    // Campo editable.
    protected $fillable = ['name'];

    // Relacion muchos a muchos con usuarios.
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    // Relacion muchos a muchos con categorias.
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
}
