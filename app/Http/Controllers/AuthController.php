<?php
// app/Http/Controllers/AuthController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $usersJson = file_get_contents(storage_path('pw.json'));
        $users = json_decode($usersJson, true);

        $credentials = $request->only('name', 'password');

        foreach ($users['users'] as $user) {
            if ($user['name'] === $credentials['name'] && Hash::check($credentials['password'], $user['password'])) {
                // Authentifizierung erfolgreich
                return response()->json(['message' => 'Login erfolgreich'], 200);
            }
        }

        // Authentifizierung fehlgeschlagen
        return response()->json(['error' => 'Ungültige Anmeldeinformationen'], 401);
    }
}

