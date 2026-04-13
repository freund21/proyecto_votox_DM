<?php

namespace App\Livewire\Admin;

use App\Models\Role;
use App\Models\Subcategory;
use App\Models\User;
use Livewire\Component;

// Componente Livewire del panel admin para gestionar usuarios.
// Livewire: estado de interfaz + metodos llamados desde botones.
// Laravel: validacion, Eloquent, relaciones y sesiones flash.
class UserManager extends Component
{
    // Estado del formulario y del usuario en edicion.
    public bool $mostrarFormulario = false;
    public ?int $idEdicion = null;

    // Datos del formulario.
    public string $dni = '';
    public string $usuario = '';
    public string $nombre_completo = '';
    public string $email = '';
    public string $contrasena = '';
    public int $id_rol = 2;
    public array $ids_subcategorias = [];

    // Prepara el formulario para un nuevo usuario.
    public function crear()
    {
        $this->reset(['idEdicion', 'dni', 'usuario', 'nombre_completo', 'email', 'contrasena', 'id_rol', 'ids_subcategorias']);
        $this->id_rol = 2;
        $this->mostrarFormulario = true;
    }

    // Carga un usuario existente para editarlo.
    public function editar(int $id)
    {
        $usuario = User::findOrFail($id);
        $this->idEdicion = $usuario->id;
        $this->dni = $usuario->dni;
        $this->usuario = $usuario->username;
        $this->nombre_completo = $usuario->full_name;
        $this->email = $usuario->email;
        $this->contrasena = '';
        $this->id_rol = $usuario->role_id;
        $this->ids_subcategorias = $usuario->subcategories->pluck('id')->toArray();
        $this->mostrarFormulario = true;
    }

    // Guarda el usuario nuevo o actualiza uno existente.
    public function guardar()
    {
        $reglas = [
            'dni' => 'required|string|unique:users,dni,' . $this->idEdicion,
            'usuario' => 'required|string|unique:users,username,' . $this->idEdicion,
            'nombre_completo' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $this->idEdicion,
            'id_rol' => 'required|exists:roles,id',
        ];

        if (! $this->idEdicion) {
            $reglas['contrasena'] = 'required|min:6';
        }

        $this->validate($reglas);

        $datos = [
            'dni' => $this->dni,
            'username' => $this->usuario,
            'full_name' => $this->nombre_completo,
            'email' => $this->email,
            'role_id' => $this->id_rol,
        ];

        if ($this->contrasena) {
            $datos['password'] = $this->contrasena;
        }

        if ($this->idEdicion) {
            $usuario = User::findOrFail($this->idEdicion);
            $usuario->update($datos);
        } else {
            $usuario = User::create($datos);
        }

        // sync() actualiza la relacion muchos a muchos con subcategorias.Un usuario puede estar relacionado con varias subcategorías.
        $usuario->subcategories()->sync($this->ids_subcategorias);

        $this->mostrarFormulario = false;
        session()->flash('message', 'Usuario guardado correctamente.');
    }

    // Elimina un usuario.
    public function eliminar(int $id)
    {
        User::findOrFail($id)->delete();
        session()->flash('message', 'Usuario eliminado.');
    }

    // Prepara datos para la tabla del panel admin.
    public function render()
    {
        return view('livewire.admin.user-manager', [
            'usuarios' => User::with(['role', 'subcategories'])->get(),
            'roles' => Role::all(),
            'subcategorias' => Subcategory::all(),
        ])->layout('layouts.app', ['title' => 'GestiÃƒÂ³n de Usuarios']);
    }
}
