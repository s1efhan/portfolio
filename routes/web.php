<?php

// routes/web.php

Route::get('/', function () {
    return view('app');
});

Route::get('/{any}', function () {
    return redirect('/');
})->where('any', '^(?!.*\/).*$'); // Umleitung für alle Pfade außer der Wurzel-URL

