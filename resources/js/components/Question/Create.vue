<template>
    <div class="flex justify-center text-lg font-bold text-red-500">
        <h4>Add New Question</h4>
    </div>
    <form @submit.prevent="storeQuestion(question)">
        <!-- Title -->
        <div>
            <label for="quiz-title" class="block text-sm font-medium text-gray-700">
                Quiz Title
            </label>
            <select v-model="question.quiz_id" name="quiz_id" id="post-category" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                <option value="" selected>-- Choose Quiz --</option>
                <option v-for="quiz in quizzes.data" :value="quiz.id">
                    {{ quiz.title }}
                </option>
            </select>
            <div class="mt-1 text-red-600">
                <div v-for="message in validationErrors?.quiz_id">
                    {{ message }}
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="mt-4">
            <label for="question-quiz" class="block text-sm font-medium text-gray-700">
                Question Text
            </label>
            <input type="text" id="question-quiz"  v-model="question.question" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"></input>
            <div class="mt-1 text-red-600">
                <div v-for="message in validationErrors?.question">
                    {{ message }}
                </div>
            </div>
        </div>
        <div class="mt-4">
            <label for="total-mark" class="block text-sm font-medium text-gray-700">
                Correct Answer
            </label>
            <input type="text" id="total-mark" v-model="question.correct_answer" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"></input>
            <div class="mt-1 text-red-600">
                <div v-for="message in validationErrors?.correct_answer">
                    {{ message }}
                </div>
            </div>
        </div>
        <div class="mt-4">
            <label for="pass-mark" class="block text-sm font-medium text-gray-700">
                Options
            </label>
            <div v-for="(option, index) in question.options" :key="index">
                <label :for="`option_${index}`">Option {{ index + 1 }}</label>
                <input v-model="question.options[index]" type="text" :id="`option_${index}`" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" />
            </div>
            <button  class="inline-flex items-center px-3 py-2 my-4 text-sm text-white uppercase bg-red-600 rounded-md disabled:opacity-75 disabled:cursor-not-allowed" type="button" @click="addOption">Add Option</button>
            <div class="mt-1 text-red-600">
                <div v-for="message in validationErrors?.options">
                    {{ message }}
                </div>
            </div>
        </div>

        <!-- Buttons -->
        <div class="mt-4">
            <button :disabled="isLoading" class="inline-flex items-center px-3 py-2 text-sm text-white uppercase bg-indigo-600 rounded-md disabled:opacity-75 disabled:cursor-not-allowed">
                <span v-show="isLoading" class="inline-block w-4 h-4 mr-2 border-t-2 border-b-2 border-l-2 border-r-2 rounded-full animate-spin border-t-white border-r-white border-b-white border-l-blue-600"></span>
                <span v-if="isLoading">Processing...</span>
                <span v-else>Save</span>
            </button>
        </div>
    </form>
</template>

<script setup>
import { onMounted, reactive  } from 'vue';
import useQuiz from '@/composables/quiz';
import useQuestion from '@/composables/question';

const { quizzes, getQuizzes  } = useQuiz();
const { storeQuestion, validationErrors,isLoading  } = useQuestion();

const addOption = () => {
  question.options.push('');
};

const question = reactive({
    quiz_id: '',
    question: '',
    correct_answer: '',
    options: [''],
});

onMounted(() => {
    getQuizzes();
})
</script>
