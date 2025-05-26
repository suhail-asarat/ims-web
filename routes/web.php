<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Models\Book;

Route::get('/', function () {
    return view('home');
});

Route::get('/books', function () {
    $books = Book::all();
    return view('books', ['books' => $books]);
});

Route::get('/book/{id}', function ($id) {
    $book = Book::findOrFail($id);
    return view('book', ['book' => $book]);
});

Route::get('/genres', function () {
    return view('genres');
});

Route::get('/authors', function () {
    return view('authors');
});

Route::get('/publishers', function () {
    return view('publishers');
});

Route::get('/blog', function () {
    return view('blog');
});

Route::get('/about', function () {
    return view('about');
});

Route::get('/contact', function () {
    return view('contact');
});
