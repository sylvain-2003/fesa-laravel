<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class PasswordController extends Controller
{
    public function demande()
    {
        return view('auth.mot-de-passe-oublie');
    }
    public function envoyer(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        $status = Password::sendResetLink($request->only('email'));
        return $status === Password::RESET_LINK_SENT
            ? back()->with('succes', 'Un lien de réinitialisation a été envoyé par e-mail.')
            : back()->withErrors(['email' => __($status)]);
    }
    public function formulaire(string $token, Request $request)
    {
        return view('auth.reinitialiser', ['token' => $token, 'email' => $request->query('email')]);
    }
    public function reinitialiser(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:6',
        ]);
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill(['password' => $password, 'tentatives_echec' => 0, 'bloque_jusqua' => null])->save();
            }
        );
        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('succes', 'Mot de passe modifié. Connectez-vous.')
            : back()->withErrors(['email' => __($status)]);
    }
}