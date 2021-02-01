<?php

namespace App\Http\Controllers;

use App\Models\Question;

class QuestionController extends Controller
{
    /**
     * Return a random question with possible answers
     *
     * @return  array
     */
    public function show()
    {
        $questionWithAnswers = $this->getQuestionWithAnswers();

        return response()->json($questionWithAnswers);
    }

    /**
     * Return a random question with answers
     *
     * @return  array
     */
    public function getQuestionWithAnswers()
    {
        $question = Question::whereUserId(auth()->id())->randomUnasked()->first();
        $answers = $this->getAnswers($question->answer);
        
        $question->markAsked();

        return [
            'id'        => $question->id,
            'question'  => $question->question,
            'answers'   => $answers,
        ];
    }

    /**
     * Get random answers
     *
     * @return  array
     */
    public function getAnswers($correctAnswer)
    {
        $correct = rand(0, 3);
        $answers = $this->getRandomNumbers(4);
        $answers[$correct] = $correctAnswer;

        return $answers;
    }

    /**
     * Generate an array of random numbers
     *
     * @return  array
     */
    public function getRandomNumbers($count)
    {
        for ($i = 0; $i < $count; $i++) {
            $numbers[] = strval(rand(1, 250));
        }

        return $numbers;
    }
}