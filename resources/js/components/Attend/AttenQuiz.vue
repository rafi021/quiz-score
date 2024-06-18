<template>
    <div class="mx-auto">
        <div class="p-6 bg-white">
            <h2 class="mb-4 text-2xl font-bold text-center">
                {{ quiz.title }}
            </h2>
            <form @submit.prevent="submitQuiz()">
                <div
                    v-for="question in quiz.questions"
                    :key="question.id"
                    class="mb-6"
                >
                    <p class="mb-2 text-lg font-semibold">
                        {{ question.question }}
                    </p>
                    <div
                        v-for="option in question.options"
                        :key="option"
                        class="mb-2"
                    >
                        <label class="flex items-center space-x-2">
                            <input
                                type="radio"
                                :name="`question_${question.id}`"
                                :value="option"
                                v-model="answers[question.id]"
                                class="w-4 h-4 text-indigo-600 transition duration-150 ease-in-out form-radio"
                            />
                            <span class="text-gray-700">{{ option }}</span>
                        </label>
                    </div>
                </div>
                <div class="text-center">
                    <button
                        type="submit"
                        class="px-4 py-2 text-white transition duration-150 ease-in-out bg-indigo-600 rounded-lg shadow-md hover:bg-indigo-700"
                    >
                        Submit Answers
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted,inject } from "vue";
import { useRoute } from "vue-router";
import useQuestion from "@/composables/question";
import useQuiz from "@/composables/quiz";

const { quiz, getQuiz } = useQuiz();
const swal = inject("$swal");
// const quiz = ref({
//     title: "",
//     questions: [],
// });
const answers = ref({});
const route = useRoute();

const submitQuiz = async () => {
        try {
            const response = await axios.post(`/api/attend/${route.params.quizId}`, {
                answers: answers.value,
            });
            swal({
                icon: "success",
                text: `Right Answer:  + ${response.data.data.right_answer} Wrong Answer:  + ${response.data.data.wrong_answer}`,
                title: `Quiz submitted! Your score is: ${response.data.data.score}`,
            });
        } catch (error) {
            console.log("Failed to submit quiz", error.response);
            swal({
                icon: "error",
                text: error?.response?.data?.message,
                title: "Your Score Was: " + error?.response?.data?.errors?.score,
            });
        }
    };
onMounted(() => {
    getQuiz(route.params.quizId);
});

</script>

<style scoped>
.quiz-container {
    max-width: 600px;
    margin: 0 auto;
}
.question {
    margin-bottom: 20px;
}
</style>
