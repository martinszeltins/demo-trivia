<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Support\Facades\Http;

class NewGameController extends Controller
{
    /**
     * Start a new game
     *
     * @return  array
     */
    public function store()
    {
        $questionsJson = Http::get(env('QUESTIONS_API'))->json();

        foreach($questionsJson as $answer => $question) {
            $questions[] = [
                'question' => $this->ask($question),
                'answer' => $answer,
            ];
        }

        $this->insertQuestionsInDB($questions);
    }

    /**
     * Transform into a question
     *
     * @return  string
     */
    public function ask($question)
    {
        $askedQuestion = preg_replace('/^\d+/', 'What', $question);

        return preg_replace('/(\.$)/', '?', $askedQuestion);
    }

    /**
     * Reset and insert the new questions in db
     *
     * @return  void
     */
    public function insertQuestionsInDB($questions)
    {
        Question::truncate();
        Question::insert($questions);
    }
}
