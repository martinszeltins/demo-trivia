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
        $question = Question::randomUnasked()->first();
        $answers = $this->getAnswers($question->answer);
        
        Question::find($question->id)->markAsked();

        return [
            'id' => $question->id,
            'question' => $question->question,
            'answers' => $answers,
        ];
    }

    /**
     * Get random answers
     *
     * @return  array
     */
    public function getAnswers($correctAnswer)
    {
        $correctAnswerPosition = rand(0, 3);

        for ($i = 0; $i < 4; $i++) {
            $answers[] = strval(rand(1, 250));
        }

        $answers[$correctAnswerPosition] = $correctAnswer;

        return $answers;
    }
}