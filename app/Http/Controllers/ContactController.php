<?php

namespace App\Http\Controllers;

use Carbon\Traits\Timestamp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\CvRequest;
class ContactController extends Controller
{

    public function sendCv(Request $request)
    {
        // Abfrage aller Daten aus der Formulardatentabelle
        $formularDaten = CvRequest::all(); // Dies hängt von deiner Datenbankstruktur und deinen Anforderungen ab
        
        // Öffnen von der view cvSend und Weitergabe der Daten
        return view('cvSend', ['formularDaten' => $formularDaten]);
    }
    public function cvDownload(Request $request)
{
    // Erfassen der Formulardaten
    $email = $request->input('email');
    $name = $request->input('name');
    $company = $request->input('company');
    $position = $request->input('position');
    
    // Speichern der Daten in der Datenbank
    $cvRequest = new CvRequest();
    $cvRequest->email = $email;
    $cvRequest->name = $name;
    $cvRequest->company = $company;
    $cvRequest->position = $position;
    $cvRequest->save();
    //email an stefan.theissen@mail.de mit den Anfragedaten

    // E-Mail an stefan.theissen@mail.de mit den Anfragedaten senden
    $empfaenger = 'stefan.theissen@mail.de';
    $nachricht = "<p>CSV-Download-Anfrage:</p>";
    $nachricht .= "<p>E-Mail: $email</p>";
    $nachricht .= "<p>Name: $name</p>";
    $nachricht .= "<p>Unternehmen: $company</p>";
    $nachricht .= "<p>Position: $position</p>";
    $nachricht .= "<p> <a href='https://stefan-theissen.de/api/lebenslauf/send'> Hier entscheiden</a>";
    
    Mail::html($nachricht, function ($message) use ($empfaenger, $name) {
        $message->to($empfaenger)
                ->subject('CSV-Download-Anfrage von '.$name);
    });

    // Erfolgsantwort zurückgeben
    return response()->json(['success' => true]);
}

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
$empfangsbestaetigung = "Guten Tag,
<br><br> vielen Dank für Ihre Nachricht über das Kontaktformular auf meiner Website stefan-theissen.de.<br> <br><br> Ich möchte Ihnen kurz mitteilen, dass ich Ihre Nachricht erhalten habe. <br><br>

Ich werde Ihre Nachricht so bald wie möglich lesen und mich bei Ihnen melden. Bitte haben Sie etwas Geduld, falls es ein paar Tage dauert.
<br><br>
Vielen Dank für Ihr Interesse und bis bald.
<br> <br> <br>
Viele Grüße
<br>
Stefan Theißen <br>
<a href='stefan-theissen.de'> stefan-theissen.de </a>
<br> <br> <br> <br> <br> <br>
Ihre Nachricht (".$thema."):
<br><br>
".$message;

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
        Mail::html($empfangsbestaetigung, function ($message) use ($fromAddress, $fromName, $email) {
            $message->to($email) // Empfängeradresse festlegen $email
                ->subject("Danke für deine Nachricht!")
                ->from($fromAddress, $fromName)
                ->replyTo($fromAddress);
        });
        

        return response()->json(['message' => 'Deine Nachricht wurde erfolgreich gesendet'], 200);
    }
}
