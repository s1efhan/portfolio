<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KnowledgeArticle;
use TCPDF;

class PDFController extends Controller
{
    public function downloadPDF(Request $request) {
        $article_id = $request->input('article_id');

        // Artikel aus der Datenbank abrufen
        $article = KnowledgeArticle::findOrFail($article_id);

        // HTML-Code aus der Spalte 'content' des Artikels extrahieren
        $html = $article->content;

        // PDF generieren
        $pdf = new TCPDF();
        $pdf->AddPage();
        $pdf->writeHTML($html, true, false, true, false, '');
        dd($pdf->Output('', 'S'));
        // Speichern des PDFs temporär
        $pdfPath = 'temp/article_' . $article_id . '.pdf';
        $pdf->Output(public_path($pdfPath), 'F');

        // PDF-Datei zum Download bereitstellen
        return response()->download(public_path($pdfPath))->deleteFileAfterSend(true);
    }
}
