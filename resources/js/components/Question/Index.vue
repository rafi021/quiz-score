<template>
    <div class="flex justify-between p-6 align-items-center">
        <h4 class="text-lg font-bold">Question List</h4>
        <router-link
            :to="{ name: 'question.create' }"
            active-class="border-b-2 border-indigo-400"
            class="inline-flex items-center px-4 py-2 font-medium leading-5 text-white transition duration-150 ease-in-out rounded-lg bg-amber-400 texts focus:outline-none focus:border-indigo-700"
        >
            Create Question
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
                                @click="updateOrdering('quiz_id')"
                            >
                                <div
                                    class="font-medium leading-4 tracking-wider text-gray-500 uppercase"
                                    :class="{
                                        'font-bold text-blue-600':
                                            orderColumn === 'id',
                                    }"
                                >
                                    Quiz Name
                                </div>
                                <div class="select-none">
                                    <span
                                        :class="{
                                            'text-blue-600':
                                                orderDirection === 'asc' &&
                                                orderColumn === 'quiz_id',
                                            hidden:
                                                orderDirection !== '' &&
                                                orderDirection !== 'asc' &&
                                                orderColumn === 'quiz_id',
                                        }"
                                        >&uarr;</span
                                    >
                                    <span
                                        :class="{
                                            'text-blue-600':
                                                orderDirection === 'desc' &&
                                                orderColumn === 'quiz_id',
                                            hidden:
                                                orderDirection !== '' &&
                                                orderDirection !== 'desc' &&
                                                orderColumn === 'quiz_id',
                                        }"
                                        >&darr;</span
                                    >
                                </div>
                            </div>
                        </th>
                        <th class="px-6 py-3 text-left bg-gray-50">
                            <div
                                class="flex flex-row items-center justify-between cursor-pointer"
                                @click="updateOrdering('question')"
                            >
                                <div
                                    class="font-medium leading-4 tracking-wider text-gray-500 uppercase"
                                    :class="{
                                        'font-bold text-blue-600':
                                            orderColumn === 'question',
                                    }"
                                >
                                    Question
                                </div>
                                <div class="select-none">
                                    <span
                                        :class="{
                                            'text-blue-600':
                                                orderDirection === 'asc' &&
                                                orderColumn === 'question',
                                            hidden:
                                                orderDirection !== '' &&
                                                orderDirection !== 'asc' &&
                                                orderColumn === 'question',
                                        }"
                                        >&uarr;</span
                                    >
                                    <span
                                        :class="{
                                            'text-blue-600':
                                                orderDirection === 'desc' &&
                                                orderColumn === 'question',
                                            hidden:
                                                orderDirection !== '' &&
                                                orderDirection !== 'desc' &&
                                                orderColumn === 'question',
                                        }"
                                        >&darr;</span
                                    >
                                </div>
                            </div>
                        </th>
                        <th class="px-6 py-3 text-left bg-gray-50">
                            <span
                                class="text-xs font-medium leading-4 tracking-wider text-gray-500 uppercase"
                                >Corrent Answer</span
                            >
                        </th>
                        <th class="px-6 py-3 text-left bg-gray-50">
                            <span
                                class="text-xs font-medium leading-4 tracking-wider text-gray-500 uppercase"
                                >Options</span
                            >
                        </th>
                        <th class="px-6 py-3 text-left bg-gray-50">
                            <span
                                class="text-xs font-medium leading-4 tracking-wider text-gray-500 uppercase"
                                >Created At</span
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
                    <tr v-for="question in questions.data">
                        <td
                            class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-no-wrap"
                        >
                            {{ question?.quiz.title }}
                        </td>
                        <td
                            class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-no-wrap"
                        >
                            {{ question?.question }}
                        </td>
                        <td
                            class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-no-wrap"
                        >
                            {{ question?.correct_answer }}
                        </td>
                        <td
                            class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-no-wrap"
                        >
                            {{ question?.options }}
                        </td>
                        <td
                            class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-no-wrap"
                        >
                            {{ question?.created_at }}
                        </td>
                        <td
                            class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-no-wrap"
                        >
                            <router-link
                                :to="{
                                    name: 'question.edit',
                                    params: { id: question.id },
                                }"
                                >Edit</router-link
                            >
                            <a
                                href="#"
                                @click.prevent="deleteQuestion(question.id)"
                                class="ml-2"
                                >Delete</a
                            >
                        </td>
                    </tr>
                </tbody>
            </table>

            <TailwindPagination
                :data="questions"
                @pagination-change-page="getQuestions"
                class="mt-4"
            />
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { TailwindPagination } from "laravel-vue-pagination";
import useQuestion from "@/composables/question";

const orderColumn = ref("created_at");
const orderDirection = ref("desc");

const { questions, getQuestions, deleteQuestion } = useQuestion();
const updateOrdering = (column) => {
    orderColumn.value = column;
    orderDirection.value = orderDirection.value === "asc" ? "desc" : "asc";
    getQuestions(1, orderColumn.value, orderDirection.value);
};

onMounted(() => {
    getQuestions();
});
</script>
