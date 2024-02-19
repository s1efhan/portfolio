<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {

        
        $credentials = $request->only('email', 'password');
         
        if (Auth::attempt($credentials)) {
            // Authentifizierung erfolgreich
            return response()->json(['message' => 'Login erfolgreich'], 200);
        }

        // Authentifizierung fehlgeschlagen
        return response()->json(['error' => 'Ungültige Anmeldeinformationen'], 401);
    }
}
