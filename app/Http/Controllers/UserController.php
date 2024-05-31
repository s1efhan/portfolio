<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::select('id', 'name')->get();
        return response()->json($users);
    }
    use AuthorizesRequests, ValidatesRequests;

    public function updateCookiePreferences(Request $request)
    {
        // Session starten
        $request->session()->start();

        $user = $request->session()->get('user');
        // preferences aus request extrahieren (entweder ist preferences: allow-all oder allow-necessary)
        $preferences = $request->input('preferences');
        // in Sessiondaten speichern
        $request->session()->put('cookiePreferences', $preferences);
    }

    public function getCookiePreferences(Request $request)
    {
        Log::info('Session Data fetching');
        $userCookiePreferences = null;
        $user = $request->session()->get('user');
        // Sessiondaten abrufen von user und preferences abrufen
        $userCookiePreferences = $request->session()->get('cookiePreferences');

        Log::info('Session Data:', ['user' => $user, 'preferences' => $userCookiePreferences]);
        return response()->json([
            'user' => $user,
            'preferences' => $userCookiePreferences
        ], 200);
    }
}