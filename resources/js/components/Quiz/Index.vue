<template>
    <div class="flex justify-between p-6 align-items-center">
        <h4 class="text-lg font-bold">Quiz List</h4>
        <router-link
            :to="{ name: 'quiz.create' }"
            active-class="border-b-2 border-indigo-400"
            class="inline-flex items-center px-4 py-2 font-medium leading-5 text-white transition duration-150 ease-in-out rounded-lg bg-amber-400 texts focus:outline-none focus:border-indigo-700"
        >
            Create Quiz
        </router-link>
    </div>
    <div class="p-6 overflow-hidden overflow-x-auto bg-white border-gray-200">
        <div class="min-w-full align-middle">
            <table class="min-w-full border divide-y divide-gray-200">
                <thead>
                    <tr>
                        <th class="px-6 py-3 text-left bg-gray-50">
                            <div
                                class="flex flex-row items-center justify-between cursor-pointer"
                                @click="updateOrdering('quiz_date')"
                            >
                                <div
                                    class="font-medium leading-4 tracking-wider text-gray-500 uppercase"
                                    :class="{
                                        'font-bold text-blue-600':
                                            orderColumn === 'id',
                                    }"
                                >
                                    Quiz Date
                                </div>
                                <div class="select-none">
                                    <span
                                        :class="{
                                            'text-blue-600':
                                                orderDirection === 'asc' &&
                                                orderColumn === 'quiz_date',
                                            hidden:
                                                orderDirection !== '' &&
                                                orderDirection !== 'asc' &&
                                                orderColumn === 'quiz_date',
                                        }"
                                        >&uarr;</span
                                    >
                                    <span
                                        :class="{
                                            'text-blue-600':
                                                orderDirection === 'desc' &&
                                                orderColumn === 'quiz_date',
                                            hidden:
                                                orderDirection !== '' &&
                                                orderDirection !== 'desc' &&
                                                orderColumn === 'quiz_date',
                                        }"
                                        >&darr;</span
                                    >
                                </div>
                            </div>
                        </th>
                        <th class="px-6 py-3 text-left bg-gray-50">
                            <div
                                class="flex flex-row items-center justify-between cursor-pointer"
                                @click="updateOrdering('title')"
                            >
                                <div
                                    class="font-medium leading-4 tracking-wider text-gray-500 uppercase"
                                    :class="{
                                        'font-bold text-blue-600':
                                            orderColumn === 'title',
                                    }"
                                >
                                    Quiz Title
                                </div>
                                <div class="select-none">
                                    <span
                                        :class="{
                                            'text-blue-600':
                                                orderDirection === 'asc' &&
                                                orderColumn === 'title',
                                            hidden:
                                                orderDirection !== '' &&
                                                orderDirection !== 'asc' &&
                                                orderColumn === 'title',
                                        }"
                                        >&uarr;</span
                                    >
                                    <span
                                        :class="{
                                            'text-blue-600':
                                                orderDirection === 'desc' &&
                                                orderColumn === 'title',
                                            hidden:
                                                orderDirection !== '' &&
                                                orderDirection !== 'desc' &&
                                                orderColumn === 'title',
                                        }"
                                        >&darr;</span
                                    >
                                </div>
                            </div>
                        </th>
                        <th class="px-6 py-3 text-left bg-gray-50">
                            <span
                                class="text-xs font-medium leading-4 tracking-wider text-gray-500 uppercase"
                                >Subject</span
                            >
                        </th>
                        <th class="px-6 py-3 text-left bg-gray-50">
                            <span
                                class="text-xs font-medium leading-4 tracking-wider text-gray-500 uppercase"
                                >Total Mark</span
                            >
                        </th>
                        <th class="px-6 py-3 text-left bg-gray-50">
                            <span
                                class="text-xs font-medium leading-4 tracking-wider text-gray-500 uppercase"
                                >Pass Mark</span
                            >
                        </th>
                        <th class="px-6 py-3 text-left bg-gray-50">
                            <span
                                class="text-xs font-medium leading-4 tracking-wider text-gray-500 uppercase"
                                >Actions</span
                            >
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 divide-solid">
                    <tr v-for="quiz in quizzes.data">
                        <td
                            class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-no-wrap"
                        >
                            {{ quiz.quiz_date }}
                        </td>
                        <td
                            class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-no-wrap"
                        >
                            {{ quiz.title }}
                        </td>
                        <td
                            class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-no-wrap"
                        >
                            {{ quiz.subject_name }}
                        </td>
                        <td
                            class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-no-wrap"
                        >
                            {{ quiz.total_mark }}
                        </td>
                        <td
                            class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-no-wrap"
                        >
                            {{ quiz.pass_mark }}
                        </td>
                        <td
                            class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-no-wrap"
                        >
                            <router-link
                                class="px-2 py-1 mr-3 text-white bg-green-600 rounded-lg"
                                :to="{
                                    name: 'result-quiz',
                                    params: { quizId: quiz.id },
                                }"
                                >Show Result</router-link
                            >
                            <router-link
                                class="px-2 py-1 mr-3 text-white bg-red-400 rounded-lg"
                                :to="{
                                    name: 'attend-quiz',
                                    params: { quizId: quiz.id },
                                }"
                                >Attend Quiz</router-link
                            >
                            <router-link
                                class="space-x-3"
                                :to="{
                                    name: 'quiz.edit',
                                    params: { id: quiz.id },
                                }"
                                >Edit</router-link
                            >
                            <a
                                href="#"
                                @click.prevent="deleteQuiz(quiz.id)"
                                class="ml-2"
                                >Delete</a
                            >
                        </td>
                    </tr>
                </tbody>
            </table>

            <TailwindPagination
                :data="quizzes"
                @pagination-change-page="getQuizzes"
                class="mt-4"
            />
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { TailwindPagination } from "laravel-vue-pagination";
import useQuiz from "@/composables/quiz";

const orderColumn = ref("quiz_date");
const orderDirection = ref("desc");

const { quizzes, getQuizzes, deleteQuiz } = useQuiz();

const updateOrdering = (column) => {
    orderColumn.value = column;
    orderDirection.value = orderDirection.value === "asc" ? "desc" : "asc";
    getQuizzes(1, orderColumn.value, orderDirection.value);
};

onMounted(() => {
    getQuizzes();
});
</script>
