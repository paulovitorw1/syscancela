<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Symfony\Component\HttpFoundation\Request;

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
    //Sobrescrevendo  a função de resetar senha, campo E-mail era obrigatorio.
    public function showResetForm(Request $request, $token = null)
    {
        return view('auth.passwords.reset')->with(
            //ANTES
            // ['token' => $token, 'email' => $request->email]
            //
            //DEPOIS
            ['token' => $token]
        );
    }
    //Sobrescrevendo  a função de resetar senha, validação, tirando email de campos obrigatorio.
    protected function rules()
    {
        return [
            'token' => 'required',
            // 'email' => 'required|email',
            'password' => 'required|confirmed|min:6',
        ];
    }
    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/login';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }
}
