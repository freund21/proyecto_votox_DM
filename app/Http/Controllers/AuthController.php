<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// Controlador clasico de Laravel (no Livewire).
// Aqui va el flujo de autenticacion: mostrar login, entrar y salir.
class AuthController extends Controller
{
    // Muestra la pantalla de login.
    // Laravel: Auth::check(), redirect(), view().
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('elections.index');
        }
        return view('auth.login');
    }

    // Procesa el formulario POST /login.
    // Laravel valida datos y prueba credenciales contra la BD.
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials)) {
            // Seguridad de sesion: regenera identificador para evitar fixation.
            $request->session()->regenerate();
            return redirect()->intended('/');
        }

        // Si falla, vuelve atras con mensaje de error.
        return back()->withErrors([
            'username' => 'Las credenciales no son correctas.',
        ])->onlyInput('username');
    }

    // Cierra sesion del usuario actual.
    public function logout(Request $request)
    {
        Auth::logout();
        // Limpia sesion y token CSRF.
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
