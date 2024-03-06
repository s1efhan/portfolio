<?php //web.php
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\PDFController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route; 
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

Route::get('/article', [ArticleController::class, 'show']);
Route::get('/downloadArticle', [PDFController::class, 'downloadPDF']);
Route::post('/logout', [AuthController::class, 'logout']);
Route::get('/knowledge_categories', [ArticleController::class, 'fetch_categories']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::get('/users', [UserController::class, 'index']);
Route::get('/knowledge_categories', [ArticleController::class, 'fetch_categories']);
Route::post('/knowledge_categories', [ArticleController::class, 'add_categories']);
Route::post('/knowledge_topic', [ArticleController::class, 'add_topic']);
Route::get('/knowledge_topic', [ArticleController::class, 'fetch_topics']);
Route::post('/addArticle', [ArticleController::class, 'addArticle']);
Route::get('/get-image-url/{imageName}', [ArticleController::class, 'getImg']);
Route::get('/userStatus', [AuthController::class, 'fetch_userStatus']);
Route::post('/contact', [ContactController::class, 'sendEmail']);
Route::post('/cv-download', [ContactController::class, 'cvDownload']);
Route::get('/lebenslauf/send', [ContactController::class, 'sendCv'])->name('lebenslauf.send');
Route::get('/email-verify/{token}', [AuthController::class, 'verify_email'])->name('email.verify');
// routes/web.php
Route::get('/articles', [ArticleController::class, 'fetch_article']);

Route::get('/{any}', function () {
    return view('app');
})->where('any', '.*');

Route::get('/', function () {
    return view('app');
})->name('home');
