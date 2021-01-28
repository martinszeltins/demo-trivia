<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnswerController;
use App\Http\Controllers\NewGameController;
use App\Http\Controllers\QuestionController;

Route::get('question',     [QuestionController::class, 'show']);
Route::post('answer',      [AnswerController::class, 'show']);
Route::post('new-game',    [NewGameController::class, 'store']);