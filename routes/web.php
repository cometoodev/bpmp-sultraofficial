<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/berita', function () {
    return view('berita.index');
});

Route::get('/berita/{id}', function ($id) {
    return view('berita.show', ['id' => $id]);
});
