<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use App\Models\Usuario;
use Illuminate\Validation\Rules\Password;


class PwdController extends Controller
{
    public function mostrarSolicitud()
    {
        return view('auth.passwords.email');
    }

    public function enviarCorreo(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:usuarios,USUARIO_CORREO']);

        $token = Str::random(60);
        DB::table('password_resets')->updateOrInsert(
            ['email' => $request->email],
            ['token' => $token, 'created_at' => now()]
        );

        $link = route('password.reset', ['token' => $token]);

        Mail::raw("Haz clic para resetear tu contraseña: $link", function ($message) use ($request) {
            $message->to($request->email)->subject('Recupera tu contraseña');
        });

        return back()->with('status', 'Hemos enviado un enlace a tu correo.');
    }

    public function mostrarFormulario($token)
    {
        return view('auth.passwords.reset', ['token' => $token]);
    }

    public function resetearPassword(Request $request)
{
    $request->validate([
        'password' => [
            'required',
            'confirmed',
            Password::min(8)->mixedCase()->numbers()->symbols()
        ],
        'token' => 'required'
    ]);

    // Buscar el registro del token
    $registro = DB::table('password_resets')->where('token', $request->token)->first();

    if (!$registro || Carbon::parse($registro->created_at)->addMinutes(60)->isPast()) {
        return back()->withErrors(['token' => 'Este enlace ya expiró o no es válido.']);
    }

    // Obtener el correo desde el registro
    $usuario = Usuario::where('USUARIO_CORREO', $registro->email)->first();
    if (!$usuario) {
        return back()->withErrors(['email' => 'No se encontró un usuario con este correo.']);
    }

    // Cambiar la contraseña
    $usuario->USUARIO_PWD = $request->password;
    $usuario->save();

    // Eliminar el token usado
    DB::table('password_resets')->where('email', $registro->email)->delete();

    return redirect()->route('login')->with('status', 'Tu contraseña ha sido cambiada.');
}

}
