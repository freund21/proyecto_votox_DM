<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Modelo Eloquent para tabla roles (ejemplo: admin, voter).
class Role extends Model
{
    // Campo editable.
    protected $fillable = ['name'];

    // Relacion: un rol puede tener muchos usuarios.
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
