<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
    
        // Überprüfen, ob der Benutzer authentifiziert werden kann
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
    
            // Überprüfen, ob die E-Mail bereits verifiziert wurde
            if ($user->email_verified_at) {
                return response()->json(['message' => 'Erfolgreich angemeldet'], 200);
            } else {
                // Wenn die E-Mail nicht verifiziert ist, senden Sie eine neue Verifizierungsmail
                $emailVerifyToken = $user->email_verify_token;
                $name = $user->name;
                $email = $user->email;
                $link = config('app.url') ."/api/email-verify/" . $emailVerifyToken;
                $nachricht = "Hallo " . $name . "!" . "<br><br> Bitte bestätige deine E-Mail-Adresse für die Account-Erstellung auf stefan-theissen.de <a href='" . $link . "'> hier.</a>";
    
                Mail::html($nachricht, function ($message) use ($email, $name) {
                    $message->to($email)
                        ->subject('Bitte bestätige deine Email ' . $name);
                });
    
                return response()->json(['message' => 'Bestätige bitte zuerst deine E-Mail Adresse'], 401);
            }
        }
    
        return response()->json(['message' => 'Ungültige Anmeldeinformationen'], 401);
    }

    public function register(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:6',
        ]);
    
        $name = strtok($request->email, '.');
    
        // Zufällig generierten Bestätigungscode erstellen
        $emailVerifyToken = uniqid();
    
        $user = User::create([
            'name' => $name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'email_verify_token' => $emailVerifyToken, // Bestätigungscode speichern
        ]);
    
        $email = $request->email;
        $link = config('app.url') ."/api/email-verify/" . $emailVerifyToken;
        $nachricht = "Hallo " . $name . "!" . "<br><br> Bitte bestätige deine E-Mail-Adresse für die Account-Erstellung auf stefan-theissen.de <a href='" . $link . "'> hier.</a>";
    
        Mail::html($nachricht, function ($message) use ($email, $name) {
            $message->to($email)
                ->subject('Bitte bestätige deine Email ' . $name);
        });
    
        return response()->json(['message' => 'Benutzer erfolgreich registriert. Überprüfen Sie Ihre E-Mail für die Verifizierung.', 'user' => $user], 201);
    }
    public function verify_email(Request $request, $token)
{
    $user = User::where('email_verify_token', $token)->first();

    if ($user) {
        $user->email_verified_at = now();
        $user->save();
        return response()->json(['message' => 'E-Mail erfolgreich verifiziert.'], 200);
    } else {
        return response()->json(['message' => 'Ungültiger Bestätigungscode.'], 404);
    }
}

}
