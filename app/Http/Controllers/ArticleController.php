<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use App\Models\KnowledgeCategory;
use App\Models\KnowledgeTopic;
use App\Models\Image;
use App\Models\KnowledgeArticle;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\ImageController;
class ArticleController extends Controller
{
    public function fetch_categories()
    {
        $KnowledgeCategories = KnowledgeCategory::select('id', 'name')->get();

        return response()->json($KnowledgeCategories);
    }
    public function addArticle(Request $request)
    {
        // Validiere die Eingaben
        $validatedData = $request->validate([
            'title' => 'required|string|unique:knowledge_articles', // Eindeutigkeit von title überprüfen
            'description' =>  'required|string|unique:knowledge_articles',
            'author' => 'required|integer',
            'topic_id' => 'required|exists:knowledge_topics,id',
            'content' => 'required|string',
            'length' => 'required|integer',
            'title_img' => 'nullable|image|mimes:jpeg,png|max:5120', //Max 5MB, nur JPEG und PNG
        ]);
    
        // Bild aus dem Request extrahieren
        if ($request->hasFile('title_img')) {
            $image = $request->file('title_img');
            
            // Hochladen des Bildes auf Imgur
            $response = Http::withHeaders([
                'Authorization' => 'Client-ID ' . env('IMGUR_CLIENT_ID'),
            ])->attach('image', file_get_contents($image), $image->getClientOriginalName())
              ->post('https://api.imgur.com/3/image');
    
            if ($response->successful()) {
                $responseData = $response->json();
                $imgurUrl = $responseData['data']['link'];
                $deleteHash = $responseData['data']['deletehash'];
    
                // Speichern der Imgur-URL oder des Delete-Hash in deiner Datenbank oder tue etwas anderes damit
                // z.B.:
                $imageModel = new Image();
                $imageModel->imgur_url = $imgurUrl;
                $imageModel->delete_hash = $deleteHash;
                $imageModel->save();
    
                // Setze den Titel-Image-Pfad auf das Imgur-URL
                $validatedData['title_img'] = $imgurUrl;
            } else {
                return response()->json(['error' => 'Failed to upload image to Imgur'], 500);
            }
        }
    
        // Erstelle den Artikel
        $article = KnowledgeArticle::create($validatedData);
    
        return response()->json(['message' => 'Artikel erfolgreich erstellt', 'article' => $article], 201);
    }
       /*   if ($request->hasFile('title_img')) {
            // Datei hochladen und Originaldateinamen beibehalten
            $path = $request->file('title_img')->store('/public/images');
    
            // Pfad manipulieren, um den öffentlichen Speicherort anzugeben
            $path = str_replace('public', 'storage', $path);
    
            // Pfad in die Validierungsdaten einfügen
            $validatedData['title_img'] = $path;
        }
    */

    

    public function fetch_topics()
    {
        $KnowledgeTopics = KnowledgeTopic::select('id', 'topic_name')->get();
        return response()->json($KnowledgeTopics);
    }
    public function fetch_article()
    {
        try {
            $knowledgeArticles = KnowledgeArticle::all();
            if ($knowledgeArticles->isEmpty()) {
                return response()->json(['data' => [], 'message' => 'Keine Artikel gefunden'], 404);
            }
            return response()->json($knowledgeArticles, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Fehler beim Abrufen der Artikel: ' . $e->getMessage()], 500);
        }
    }
    

    public function  getImg($imageName){
        $imageUrl = Storage::url('public/images/' . $imageName);

        return response()->json(['url' => $imageUrl]);
    }
    public function add_categories(Request $request)
    {
        // Validierung der Eingaben
        $request->validate([
            'knowledge_category_name' => 'required|string|max:255', // Annahme, dass der Name der Kategorie im Request enthalten ist
        ]);

        // Überprüfen, ob die Kategorie bereits existiert
        $existingCategory = KnowledgeCategory::where('name', $request->input('knowledge_category_name'))->first();

        if ($existingCategory) {
            return response()->json(['error' => 'Die Kategorie existiert bereits'], 400);
        }

        // Neue Kategorie erstellen
        $category = new KnowledgeCategory();
        $category->name = $request->input('knowledge_category_name');
        $category->nav_item = $request->input('nav_item');
        $category->save();

        return response()->json(['message' => 'Kategorie erfolgreich hinzugefügt'], 201);
    }

    public function add_topic(Request $request)
    {
        // Validierung der Eingaben
        $request->validate([
            'topic_name' => 'required|string|max:255',
            'knowledge_category_id' => 'required|exists:knowledge_categories,id'
        ]);

        // Neues Thema erstellen
        $topic = new KnowledgeTopic();
        $topic->topic_name = $request->input('topic_name');
        $topic->category_id = $request->input('knowledge_category_id'); // Use 'knowledge_category_id' here
        $topic->save();

        return response()->json(['message' => 'Thema erfolgreich hinzugefügt'], 201);
    }

}