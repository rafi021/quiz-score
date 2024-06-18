<template>
    <div class="flex justify-between p-6 align-items-center">
        <h4 class="text-lg font-bold">Quiz Result</h4>
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
                                >Student Name</span
                            >
                        </th>
                        <th class="px-6 py-3 text-left bg-gray-50">
                            <span
                                class="text-xs font-medium leading-4 tracking-wider text-gray-500 uppercase"
                                >Score</span
                            >
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 divide-solid">
                    <tr v-for="result in results.data">
                        <td
                            class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-no-wrap"
                        >
                            {{ result?.quiz?.quiz_date}}
                        </td>
                        <td
                            class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-no-wrap"
                        >
                            {{ result?.quiz?.title }}
                        </td>
                        <td
                            class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-no-wrap"
                        >
                            {{ result?.quiz?.subject_name }}
                        </td>
                        <td
                            class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-no-wrap"
                        >
                            {{ result?.student?.name }}
                        </td>
                        <td
                            class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-no-wrap"
                        >
                            {{ result?.score }}
                        </td>
                    </tr>
                </tbody>
            </table>

            <TailwindPagination
                :data="results"
                @pagination-change-page="getResult"
                class="mt-4"
            />
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { TailwindPagination } from "laravel-vue-pagination";
import useQuiz from "@/composables/quiz";
import { useRoute } from "vue-router";

const orderColumn = ref("quiz_date");
const orderDirection = ref("desc");
const route = useRoute();

const { getResult, results } = useQuiz();

const updateOrdering = (column) => {
    orderColumn.value = column;
    orderDirection.value = orderDirection.value === "asc" ? "desc" : "asc";
    getResult(1, orderColumn.value, orderDirection.value);
};

onMounted(() => {
    getResult(route.params.quizId);
});
</script>
