<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Modelo Eloquent para tabla categories.
// Una categoria pertenece a una eleccion y contiene opciones de voto.
class Category extends Model
{
    // Campos que se pueden guardar con create()/update().
    protected $fillable = ['election_id', 'name', 'max_selections'];

    // Relacion: esta categoria pertenece a una eleccion.
    public function election()
    {
        return $this->belongsTo(Election::class);
    }

    // Relacion: una categoria tiene muchas opciones.
    public function options()
    {
        return $this->hasMany(Option::class);
    }

    // Relacion muchos a muchos: subcategorias habilitadas para votar aqui.
    public function subcategories()
    {
        return $this->belongsToMany(Subcategory::class);
    }

    // Relacion: votos emitidos en esta categoria.
    public function votes()
    {
        return $this->hasMany(Vote::class);
    }
}
