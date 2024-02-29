<?php

namespace App\Http\Controllers;

use Carbon\Traits\Timestamp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function sendEmail(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'message' => 'required',
            'thema' => 'required'
        ]);
        $thema = $validatedData['thema'];
        $name = $validatedData['name'];
        $email = $validatedData['email'];
        $message = $validatedData['message'];
        $mailinhalt = "Hey Stefan, du hast eine neue Mail!<br>Nachricht zu " .
        $thema . " von " . $name . "<br>Email: " . $email . "<br>Nachricht: " .
         $message . "<br><br>Datum: " . date('H:i \U\h\r \a\m j\.m\.Y');


        // Setze die Absenderadresse explizit
        $fromAddress = env('MAIL_FROM_ADDRESS');
        $fromName = env('MAIL_FROM_NAME');

        // Hier können Sie die E-Mail-Nachricht direkt senden
        Mail::html($mailinhalt, function ($message) use ($fromAddress, $fromName) {
            $message->to('stefan.theissen@mail.de') // Empfängeradresse festlegen
                ->subject("Neue Nachricht")
                ->from($fromAddress, $fromName)
                ->replyTo($fromAddress); // Antwortadresse auf die des Absenders setzen
        });
        

        return response()->json(['message' => 'E-Mail an ' . $email . ' wurde gesendet'], 200);
    }
}
