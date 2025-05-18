<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Usuario;

class loginController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::guard('Usuario')->check()) {
            return $this->redirectToPanel(Auth::guard('Usuario')->user());
        }
        // Si el usuario ya está autenticado, redirigir a la página de inicio
        return view('auth.login');
    }

     public function login(Request $request){
        $request->validate([
            'correo' => 'required|email',
            'contraseña' => 'required',
        ]);

        $credenciales = [
            'USUARIO_CORREO' => $request->input('correo'),
            'password' => $request->input('contraseña'),
        ];
        
        $usuario = Usuario::where('USUARIO_CORREO', $credenciales['USUARIO_CORREO'])->first();

        
        if (Auth::guard('Usuario')->attempt($credenciales)) {
            Auth::guard('Usuario')->login($usuario);
            if(Auth::check()){
                logger('Usuario autenticado' . Auth::id());
            }
            else{
                logger('el uuario no fue autenticado');
            }
            return $this->redirectToPanel(Auth::guard('Usuario')->user());
        }
        
        return back()->withErrors([
            'correo' => 'Las credenciales proporcionadas no coinciden con nuestros registros.',
        ])->onlyInput('correo');

    }

    public function logout(Request $request)
    {
        Auth::guard('Usuario')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        $request->session()->flush();
        return redirect('/')->with('success', 'Has cerrado sesión correctamente.');
    }

    public function redirectToPanel($permision){
        switch ($permision->USUARIO_ROL) {
            case 'ADMINISTRADOR':
                return redirect()->route('Admin.main')->with('success','Bienvenido ADMINISTRADOR');
            case 'EMPLEADO':
                return redirect()->route('Empleado.main')->with('success', 'Bienvenido EMPLEADO');
            case 'CLIENTE':
                return redirect()->route('Usuario.main')->with('success', 'Bienvenido CLIENTE');
            default:
                return redirect('/')->with('error', 'Rol no reconocido');
        }

    }
}
