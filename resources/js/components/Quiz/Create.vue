<template>
    <div class="flex justify-center text-lg font-bold text-red-500">
        <h4>Add New Quiz</h4>
    </div>
    <form @submit.prevent="storeQuiz(quiz)">
        <!-- Title -->
        <div>
            <label for="quiz-title" class="block text-sm font-medium text-gray-700">
                Title
            </label>
            <input id="quiz-title"  v-model="quiz.title" type="text" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
            <div class="mt-1 text-red-600">
                <div v-for="message in validationErrors?.title">
                    {{ message }}
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="mt-4">
            <label for="quiz-subject" class="block text-sm font-medium text-gray-700">
                Subject
            </label>
            <input type="text" id="quiz-subject"  v-model="quiz.subject_name" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"></input>
            <div class="mt-1 text-red-600">
                <div v-for="message in validationErrors?.subject_name">
                    {{ message }}
                </div>
            </div>
        </div>
        <div class="mt-4">
            <label for="total-mark" class="block text-sm font-medium text-gray-700">
                Total Mark
            </label>
            <input type="number" id="total-mark" v-model="quiz.total_mark" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"></input>
            <div class="mt-1 text-red-600">
                <div v-for="message in validationErrors?.total_mark">
                    {{ message }}
                </div>
            </div>
        </div>
        <div class="mt-4">
            <label for="pass-mark" class="block text-sm font-medium text-gray-700">
                Pass Mark
            </label>
            <input type="number" id="pass-mark" v-model="quiz.pass_mark" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"></input>
            <div class="mt-1 text-red-600">
                <div v-for="message in validationErrors?.pass_mark">
                    {{ message }}
                </div>
            </div>
        </div>

        <!-- Quiz Date -->
        <div class="mt-4">
            <label for="quiz-date" class="block text-sm font-medium text-gray-700">
                Quiz Date
            </label>
            <input type="datetime-local" name="quiz_date" v-model="quiz.quiz_date"  id="quiz-date" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
            <div class="mt-1 text-red-600">
                <div v-for="message in validationErrors?.quiz_date">
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

const { storeQuiz, validationErrors, isLoading   } = useQuiz();

const quiz = reactive({
    title: '',
    subject_name: '',
    total_mark: '',
    pass_mark: '',
    quiz_date: ''
});

const submit = () => {
    console.log('submitted')
}

onMounted(() => {

})
</script>
