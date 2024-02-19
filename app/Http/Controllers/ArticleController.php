<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use App\Models\KnowledgeCategory;
use App\Models\KnowledgeTopic;

class ArticleController extends Controller
{
    public function fetch_categories()
    {
        $KnowledgeCategories = KnowledgeCategory::select('id', 'name')->get();
        return response()->json($KnowledgeCategories);
    }
    public function fetch_topics()
    {
        $KnowledgeTopics = KnowledgeTopic::select('id', 'topic_name')->get();
        return response()->json($KnowledgeTopics);
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