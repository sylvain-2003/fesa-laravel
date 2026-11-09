<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showRegister()
    {
    return view('auth.register');
    }
    // CU01 – Créer un compte
    public function register(Request $request)
    {
        $data = $request->validate([
            'type_membre' => ['required', 'in:particulier,entreprise'],
            'nif' => ['required_if:type_membre,entreprise', 'nullable', 'string', 'min:5', 'max:30', 'regex:/^[A-Za-z0-9\-\/ ]+$/', 'unique:users,nif'],
            'type_piece' => ['required', 'in:cni,passeport'],
            'numero_piece' => ['required', 'string', 'min:5', 'max:30', 'regex:/^[A-Za-z0-9\-\/ ]+$/'],
            'pseudo' => ['required', 'string', 'max:50', 'unique:users,pseudo'],
            'nom' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'confirmed', 'min:6'],
        ], [
            'nif.required_if' => 'Le NIF est obligatoire pour une entreprise.',
            'nif.unique' => 'Ce NIF est déjà enregistré.',
            'nif.regex' => 'Le NIF ne doit contenir que des lettres, des chiffres, des espaces, des tirets ou des barres obliques.',
            'type_piece.required' => 'Choisissez le type de pièce d’identité.',
            'numero_piece.required' => 'Le numéro de la pièce d’identité est obligatoire.',
            'numero_piece.regex' => 'Le numéro de pièce contient des caractères non autorisés.',
        ]);

    // Un particulier n'a pas de NIF
    if ($data['type_membre'] === 'particulier') {
        $data['nif'] = null;
    }

    // Écriture uniforme : sans espaces, en majuscules
    $data['numero_piece'] = strtoupper(preg_replace('/\s+/', '', $data['numero_piece']));
    if (! empty($data['nif'])) {
        $data['nif'] = strtoupper(trim($data['nif']));
    }

    // La même pièce ne peut pas servir à deux comptes
    $dejaUtilisee = User::where('type_piece', $data['type_piece'])
        ->where('numero_piece', $data['numero_piece'])->exists();
    if ($dejaUtilisee) {
        return back()->withErrors(['numero_piece' => 'Cette pièce d’identité est déjà associée à un compte.'])->withInput();
    }

    $user = User::create($data);
    Auth::login($user);

    return redirect()->route('accueil')->with('succes', 'Compte créé avec succès.');
    }
    public function showLogin()
    {
    return view('auth.login');
    }
    // CU05 – Se connecter
    public function login(Request $request)
    {
        $request->validate(['pseudo' => 'required', 'password' => 'required']);
        $user = User::where('pseudo', $request->pseudo)->first();
        if ($user && $user->bloque_jusqua && $user->bloque_jusqua->isFuture()) {
        $min = (int) ceil(now()->diffInMinutes($user->bloque_jusqua));
        return back()->withErrors(['pseudo' => "Trop de tentatives. Patientez encore $min minute(s)."])->onlyInput
        ('pseudo');
        }
        if (! $user || ! Hash::check($request->password, $user->password)) {
        if ($user) {
        $user->increment('tentatives_echec');
        if ($user->tentatives_echec == 3) {
        $user->update(['bloque_jusqua' => now()->addMinutes(5)]);
        }
        if ($user->tentatives_echec >= 6) {
        $user->update(['actif' => false]);
        }
        }
        return back()->withErrors(['pseudo' => 'Pseudo ou mot de passe incorrect.'])->onlyInput('pseudo');
        }
        if (! $user->actif) {
        return back()->withErrors(['pseudo' => 'Votre compte est désactivé. Contactez l’administrateur.'])->onlyInput('pseudo');
        }
        $user->update(['tentatives_echec' => 0, 'bloque_jusqua' => null]);
        Auth::login($user, $request->boolean('remember'));
        $request->session()->regenerate();
        return redirect()->intended($user->estAdmin() ? route('admin.index') : route('accueil'));
    }
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('accueil');
    }
}