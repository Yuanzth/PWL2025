<?php

use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\PhotoController; 
// use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

Route::resource('photos', PhotoController::class); 
// Route::get('/hello', function () {
//     return 'Hello World';
// });
Route::get('/world', function () {
    return 'World';
});
// Route::get('/SelamatDatang', function () {
//     return 'Selamat Datang';
// });
// Route::get('/About', function () {
//     return 'Nama = Aditya Yuhanda <br>Putra NIM = 2341760050';
// });
Route::get('/user/{name}', function ($name) {
    return 'Nama saya ' . $name;
});
Route::get('/posts/{post}/comments/{comment}', function 
($postId, $commentId) { 
    return 'Pos ke-'.$postId." Komentar ke-: ".$commentId; 
}); 
// Route::get('/articles/{id}', function ($id) {
//     return 'Halaman Artikel dengan ID '.$id;
// });
// Route::get('/user/{name?}', function ($name=null) {
//     return 'Nama saya '.$name;
// });
Route::get('/user/{name?}', function ($name='John') {
    return 'Nama saya '.$name;
    });
Route::get('/hello', [WelcomeController::class, 'hello']);
// Route::get('/', [PageController::class, 'index']);
// Route::get('/about', [PageController::class, 'about']);
// Route::get('/articles/{id}', [PageController::class, 'articles']);

Route::get('/', HomeController::class);
Route::get('/about', AboutController::class);
Route::get('/articles/{id}', ArticleController::class);

Route::resource('photos', PhotoController::class)->only([
    'index', 'show'
   ]);
Route::resource('photos', PhotoController::class)->except([
    'create', 'store', 'update', 'destroy'
   ]);
// Route::get('/greeting', function () {  	
//     return view('blog.hello', ['name' => 'Andi']); 
// }); 
   
Route::get('/greeting', [WelcomeController::class,'greeting']); 


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

