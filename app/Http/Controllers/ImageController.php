<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Image;

class ImageController extends Controller
{
    /**
     * Speichere das hochgeladene Bild und gibt seine Informationen zurück.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function upload(Request $request)
    {
        // Validiere die Eingaben
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png|max:5120', //Max 5MB, nur JPEG und PNG
        ]);

        // Bild aus dem Request extrahieren
        $image = $request->file('image');

        // Hochladen des Bildes auf Imgur
        $response = Http::withHeaders([
            'Authorization' => 'Client-ID ' . env('IMGUR_CLIENT_ID'),
        ])->attach('image', file_get_contents($image), $image->getClientOriginalName())
          ->post('https://api.imgur.com/3/image');

        if ($response->successful()) {
            $responseData = $response->json();
            $imgurUrl = $responseData['data']['link'];
            $deleteHash = $responseData['data']['deletehash'];

            // Speichern der Imgur-URL oder des Delete-Hash in der Datenbank
            $imageModel = new Image();
            $imageModel->imgur_url = $imgurUrl;
            $imageModel->delete_hash = $deleteHash;
            $imageModel->save();

            // Rückgabe der Bildinformationen
            return response()->json(['imgur_url' => $imgurUrl, 'delete_hash' => $deleteHash], 200);
        } else {
            return response()->json(['error' => 'Failed to upload image to Imgur'], 500);
        }
    }

    /**
     * Gibt die Informationen eines Bildes anhand seiner ID zurück.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $image = Image::findOrFail($id);

        return response()->json($image, 200);
    }
}
