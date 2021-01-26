<?php

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

Route::get('questions', function() {
    return Http::get('http://numbersapi.com/1..100');
});