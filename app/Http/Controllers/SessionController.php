<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SessionController extends Controller
{
    public function fetchSession(Request $request)
    {
        // Überprüfen, ob die Session einen Eintrag 'logged_in' hat
        if ($request->session()->has('logged_in')) {
            // Session-Daten existieren
            $userName = $request->session()->get('user_name');
            $loggedIn = $request->session()->get('logged_in');
        } else {
            // Session-Daten existieren nicht
            $userName = "";
            $loggedIn = false;
        }
    
        // Session-Daten als JSON zurückgeben
        return response()->json([
            'userName' => $userName,
            'loggedIn' => $loggedIn
        ]);
    }
}
