<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnswerController;
use App\Http\Controllers\NewGameController;
use App\Http\Controllers\QuestionAndAnswersController;

Route::get('question',     [QuestionAndAnswersController::class, 'show']);
Route::get('answer',       [AnswerController::class, 'show']);
Route::post('new-game',    [NewGameController::class, 'store']);