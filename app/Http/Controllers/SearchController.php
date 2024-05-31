<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->query('query');
        $results = [
            'Test1' => 'Testergebnis 1',
            'Test2' => 'Testergebnis 2'
        ];
        return response()->json($results);
    }
}