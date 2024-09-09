<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\ImageController;


Route::get('/welcome', function () {
    return view('welcome');
});
Route::get('/', function () {
    return view('login');
});


Route::get('/form', function () {
    return view('form');
})->middleware('auth');

// -------------
Route::get('/home', [NoteController::class, 'countNote']);
// --------------


Route::group(['middleware' => 'guest'], function () {
    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/register', [AuthController::class, 'registerPost'])->name('register');
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'loginPost'])->name('login');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home.page');
    Route::delete('/logout', [AuthController::class, 'logout'])->name('logout');
});

// เส้นทางที่ใช้สำหรับการแสดงจำนวนโน้ต
Route::get('/home', [NoteController::class, 'countNote'])->name('home')->middleware('auth');

Route::get('/home', [NoteController::class, 'index'])->name('notes.index');

// Route::get('/home', [NoteController::class, 'index'])->name('notes.index');
// Route::get('/home', [NoteController::class, 'home'])->name('home');

Route::get('/notes', [NoteController::class, 'index'])->name('notes.index');
Route::get('/notes/create', [NoteController::class, 'create'])->name('notes.create');
Route::post('/notes', [NoteController::class, 'store'])->name('notes.store');
Route::get('/notes/{note}/edit', [NoteController::class, 'edit'])->name('notes.edit');
Route::put('/notes/{note}', [NoteController::class, 'update'])->name('notes.update');
Route::delete('/notes/{note}', [NoteController::class, 'destroy'])->name('notes.destroy');

Route::get('/home', [HomeController::class, 'search'])->name('home');



Route::group(['middleware' => ['custom_auth:1']], function () {
    Route::get('/user-a-dashboard', [AuthController::class, 'index']);
});

Route::group(['middleware' => ['custom_auth:2']], function () {
    Route::get('/user-b-dashboard', [AuthController::class, 'index']);
});
Route::resource('files', FileController::class);
Route::resource('images', ImageController::class);

Route::get('/home/files', [FileController::class, 'index'])->name('home.files');
Route::get('/home/images', [ImageController::class, 'index'])->name('home.images');

Route::get('/image/{id}', [ImageController::class, 'show']);

Route::resource('notes', NoteController::class);
Route::post('/notes/{note}/delete-files', [NoteController::class, 'deleteFiles'])->name('notes.deleteFiles');
Route::delete('/notes/{note}/delete-files', [NoteController::class, 'deleteFiles'])->name('notes.deleteFiles');

// เส้นทางสำหรับการแสดงฟอร์มแก้ไข
Route::get('notes/{note}/edit', [NoteController::class, 'edit'])->name('notes.edit')->middleware('auth');

// เส้นทางสำหรับการอัปเดตโน้ต
Route::put('notes/{note}', [NoteController::class, 'update'])->name('notes.update');
