<?php

namespace App\Http\Controllers;

use App;
use Illuminate\Http\Request;
use App\Models\KnowledgeArticle;
use Barryvdh\DomPDF\Facade\Pdf;

class PDFController extends Controller
{
    public function downloadPDF(Request $request)
    {
        $article_id = $request->input('article_id');

        // Artikel aus der Datenbank abrufen
        $article = KnowledgeArticle::findOrFail($article_id);
        $html = $article->content;
        $html = $html . "<br> <br> Viel Spaß mit dem Artikel! <br> <a href='https//stefan-theissen.de" . $article->article_url . "'> Link zum Artikel </a>";
        $pdf = App::make('dompdf.wrapper');
        $pdf = Pdf::loadHTML($html);
        return $pdf->download($article->name . 'pdf');
    }
}
