<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\DB;


class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/';


    public function reset(Request $request)
{
    $request->validate($this->rules(), $this->validationErrorMessages());

    $status = Password::reset(
        $this->credentials($request),
        function ($user, $password) {
            $this->resetPassword($user, $password);
        }
    );

    if ($status === Password::PASSWORD_RESET) {
        // 🔁 Elimina el token después del cambio exitoso
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return redirect($this->redirectPath())
            ->with('status', '¡Tu contraseña ha sido cambiada con éxito!');
    }

    // Manejo de errores personalizados
    return back()->withErrors([
        'email' => match ($status) {
            Password::INVALID_TOKEN => 'El token de restablecimiento no es válido o ha expirado.',
            Password::INVALID_USER => 'No encontramos un usuario con ese correo.',
            Password::RESET_THROTTLED => 'Debes esperar un momento antes de intentar de nuevo.',
            default => 'No se pudo restablecer la contraseña. Inténtalo nuevamente.',
        }
    ]);
}


    public function showResetForm(Request $request, $token = null)
{
    return view('auth.passwords.reset')->with([
        'token' => $token,
        'email' => $request->email,
    ]);
}
}
