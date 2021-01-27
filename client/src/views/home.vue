<template>
    <teleport to="head">
        <title>Trivia</title>
    </teleport>

    <div class="app-container">
        <div class="game">
            <div
                class="game__loading"
                :class="{ 'visible': isLoading }">
                Loading...
            </div>

            <div class="game__question">
                {{ currentQuestion }}
            </div>

            <div class="game__answers">
                <div
                    @click="answerQuestion(answers[0])"
                    class="game__answer">
                    A: {{ answers[0] }}
                </div>

                <div
                    @click="answerQuestion(answers[1])"
                    class="game__answer">
                    B: {{ answers[1] }}
                </div>

                <div
                    @click="answerQuestion(answers[2])"
                    class="game__answer">
                    C: {{ answers[2] }}
                </div>

                <div
                    @click="answerQuestion(answers[3])"
                    class="game__answer">
                    D: {{ answers[3] }}
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
    import { ref } from 'vue'
    import Questions from '../api/questions.js'

    const questions = ref([])
    const currentQuestion = ref('')
    const currentQuestionNumber = ref(0)
    const QUESTION = 1
    const ANSWER = 0
    const answers = ref([])
    const isLoading = ref(false)

    async function startGame() {
        currentQuestionNumber.value = 0

        questions.value = await getQuestions()
        currentQuestion.value = ask(questions.value[currentQuestionNumber.value][QUESTION])
        makeAnswers()
    }

    async function getQuestions() {
        isLoading.value = true

        let questions = await Questions.get()
        questions = Object.entries(questions)
        
        isLoading.value = false

        return questions.sort(() => Math.random() - 0.5)
    }

    function ask(question) {
        return question.replace(/^\d+/, 'What').replace(/(\.$)/, '?')
    }

    function makeAnswers() {
        let correctAnswer = Math.floor(Math.random() * 3) + 1

        for (let i = 0; i < 4; i++) {
            answers.value[i] = Math.floor(Math.random() * (200 - 10 + 1) + 10)
        }

        answers.value[correctAnswer] = questions.value[currentQuestionNumber.value][ANSWER]
    }

    function answerQuestion(answer) {
        if (currentQuestionNumber.value == 3) {
            winGame()
            return
        }

        if (questions.value[currentQuestionNumber.value][ANSWER] === answer) {
            getNextQuestion()
        } else {
            alert('Wrong answer. The correct answer was ' + questions.value[currentQuestionNumber.value][ANSWER])
            startGame()
        }
    }

    function getNextQuestion() {
        currentQuestionNumber.value = currentQuestionNumber.value + 1
        currentQuestion.value = ask(questions.value[currentQuestionNumber.value][QUESTION])
        makeAnswers()
    }

    function winGame() {
        alert('Congratulations! You have won the game!')
        startGame()
    }

    startGame()
</script>