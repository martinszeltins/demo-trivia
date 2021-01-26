<template>
    <teleport to="head">
        <title>Trivia</title>
    </teleport>

    <div class="app-container">
        <div class="game">
            <div class="game__question">
                What is the number of tools in the Wenger Swiss Army Knife version XXL, listed in the Guinness Book of World Records as the world's most multi-functional penknife?
            </div>

            <div class="game__answers">
                <div class="game__answer">A: I dont know</div>
                <div class="game__answer">B: I dont know</div>
                <div class="game__answer">C: I dont know</div>
                <div class="game__answer">D: I dont know</div>
            </div>
        </div>
    </div>
</template>

<script setup>
    import { ref } from 'vue'
    import Questions from '../api/questions.js'

    const questions = ref([])
    const currentNumber = ref(1)
    const currentQuestion = ref(1)

    async function startGame() {
        const questions = await Questions.get()

        let questionKeys = Object.keys(questions)
        questionKeys = questionKeys.sort(() => Math.random() - 0.5)
    }

    startGame()
</script>