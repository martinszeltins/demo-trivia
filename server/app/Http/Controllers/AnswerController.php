<?php

namespace App\Http\Controllers;

use App\Models\Question;

class AnswerController extends Controller
{
    /**
     * Show if the chosen answer is correct
     *
     * @return  array
     */
    public function show()
    {
        $question = Question::find(request('id'));

        if ($question->answer == request('answer')) {
            return response()->json([
                'is_correct' => 1,
            ]);
        }

        return response()->json([
            'is_correct' => 0,
            'correct_answer' => $question->answer,
        ]);
    }
}
