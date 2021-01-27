<template>
    <teleport to="head">
        <title>Trivia</title>
    </teleport>

    <div class="app-container">
        <div class="game">
            <transition name="bounce">
                <div v-if="showThumbsUp" class="game__thumbs-up">
                    <svg-thumbs-up />
                </div>
            </transition>
            
            <div
                class="game__loading"
                :class="{ 'visible': isLoading }">
                Loading...
            </div>

            <div class="game__question">
                {{ currentQuestion }}

                <div class="game__question-count">
                    {{ currentQuestionNumber + 1 }}
                </div>
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
    import SvgThumbsUp from '../components/ThumbsUp.vue'

    const ANSWER = 0
    const QUESTION = 1
    const answers = ref([])
    const questions = ref([])
    const isLoading = ref(false)
    const currentQuestion = ref('')
    const showThumbsUp = ref(false)
    const currentQuestionNumber = ref(0)

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
        if (questions.value[currentQuestionNumber.value][ANSWER] === answer) {
            if (currentQuestionNumber.value == 19) { winGame(); return }
            showThumbsUpIcon()
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
        throwConfetti()
        startGame()
    }

    function throwConfetti() {
        window.confetti.start()

        setTimeout(() => {
            window.confetti.remove()
        }, 8000)
    }

    function showThumbsUpIcon() {
        showThumbsUp.value = true

        let timeout = setTimeout(() => {
            showThumbsUp.value = false
            clearTimeout(timeout)
        }, 1000)
    }

    startGame()
</script>