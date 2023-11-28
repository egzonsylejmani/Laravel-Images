<?php

use App\Http\Controllers\DeleteTemporaryImageController;
use App\Http\Controllers\ImagesController;
use App\Http\Controllers\StorePostController;
use App\Http\Controllers\UploadTemporaryImageController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', WelcomeController::class);

Route::post('/upload', UploadTemporaryImageController::class);
Route::delete('/delete', DeleteTemporaryImageController::class);
Route::post('/', StorePostController::class);

Route::get('/posts', [ImagesController::class, 'index']);

// routes/web.php

Route::get('/posts/{postId}/download', [ImagesController::class, 'downloadImages']);
