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
                {{ currentQuestion.question }}

                <div class="game__question-count">
                    {{ currentQuestionNumber + 1 }}
                </div>
            </div>

            <div class="game__answers">
                <div
                    @click="answerQuestion(currentQuestion.answers[0])"
                    class="game__answer">
                    A: {{ currentQuestion.answers[0] }}
                </div>

                <div
                    @click="answerQuestion(currentQuestion.answers[1])"
                    class="game__answer">
                    B: {{ currentQuestion.answers[1] }}
                </div>

                <div
                    @click="answerQuestion(currentQuestion.answers[2])"
                    class="game__answer">
                    C: {{ currentQuestion.answers[2] }}
                </div>

                <div
                    @click="answerQuestion(currentQuestion.answers[3])"
                    class="game__answer">
                    D: {{ currentQuestion.answers[3] }}
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
    import { ref } from 'vue'
    import Game from '../api/game.js'
    import Answer from '../api/answer.js'
    import Question from '../api/question.js'
    import SvgThumbsUp from '../components/ThumbsUp.vue'

    const currentQuestion = ref({
        id: '',
        question: '',
        answers: [],
    })

    const isLoading = ref(false)
    const showThumbsUp = ref(false)
    const currentQuestionNumber = ref(0)

    async function startGame() {
        isLoading.value = true

        currentQuestionNumber.value = 0

        await Game.startNew()
        currentQuestion.value = await Question.get()

        isLoading.value = false
    }

    async function answerQuestion(answer) {
        isLoading.value = true

        const result = await Answer.answerQuestion({
            id: currentQuestion.value.id,
            answer: answer,
        })

        isLoading.value = false

        if (result.is_correct) {
            if (currentQuestionNumber.value == 19) { winGame(); return }
            showThumbsUpIcon()
            getNextQuestion()
        } else {
            alert(`Wrong answer. The correct answer was ${result.correct_answer}`)
            startGame()
        }
    }

    async function getNextQuestion() {
        currentQuestionNumber.value = currentQuestionNumber.value + 1

        isLoading.value = true
        currentQuestion.value = await Question.get()
        isLoading.value = false
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