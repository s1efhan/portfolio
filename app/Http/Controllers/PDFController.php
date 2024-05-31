<?php

namespace App\Http\Controllers;

use App;
use Illuminate\Http\Request;
use App\Models\KnowledgeArticle;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;
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
    public function downloadCensoredCV()
    {
        $filePath = Storage::disk('public')->path('images/censoredCV.pdf');

        if (!Storage::disk('public')->exists('images/censoredCV.pdf')) {
            abort(404, 'File not found');
        }

        $headers = [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="Lebenslauf_Stefan_Theissen_zensiert.pdf"',
        ];

        return response()->download($filePath, 'Lebenslauf_Stefan_Theissen_zensiert.pdf', $headers);
    }
}
