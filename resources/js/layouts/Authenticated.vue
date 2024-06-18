<template>
    <div class="min-h-screen bg-gray-100">
        <nav class="bg-white border-b border-gray-100">
            <!-- Primary Navigation Menu -->
            <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <!-- Navigation Links -->
                        <div
                            class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex"
                        >
                            <router-link
                                :to="{ name: 'quiz.index' }"
                                active-class="border-b-2 border-indigo-400"
                                class="inline-flex items-center px-1 pt-1 text-sm font-medium leading-5 text-gray-900 transition duration-150 ease-in-out focus:outline-none focus:border-indigo-700"
                            >
                                Quiz
                            </router-link>

                            <router-link v-show="user.isAdmin"
                                :to="{ name: 'question.index' }"
                                active-class="border-b-2 border-indigo-400"
                                class="inline-flex items-center px-1 pt-1 text-sm font-medium leading-5 text-gray-900 transition duration-150 ease-in-out focus:outline-none focus:border-indigo-700"
                            >
                                Question
                            </router-link>

                        </div>
                    </div>
                    <div class="flex items-center">
                        <div class="flex">
                            <div>
                                <div>Hi, {{ user.name }}</div>
                                <div class="text-sm text-gray-500">
                                    {{ user.email }}
                                </div>
                            </div>
                        </div>
                        <div>
                            <button
                                @click="logout"
                                type="button"
                                class="inline-flex items-center px-4 py-2 ml-4 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-gray-800 border border-transparent rounded-md hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray"
                                :class="{ 'opacity-25': processing }"
                                :disabled="processing"
                            >
                                Log out
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Heading -->
        <header class="bg-white shadow">
            <div class="px-4 py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Dashboard
                </h2>
            </div>
        </header>

        <!-- Page Content -->
        <main>
            <div class="py-12">
                <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <div
                        class="overflow-hidden bg-white shadow-sm sm:rounded-lg"
                    >
                        <div class="p-6 bg-white border-b border-gray-200">
                            <router-view></router-view>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</template>
<script setup>
import { computed, onMounted } from "vue";
import { useRoute } from "vue-router";
import useAuth from "@/composables/auth";

const route = useRoute();
const { user, processing, logout, getUser } = useAuth();

const currentPageTitle = computed(() => route.meta.title);

onMounted(() => {
    getUser();
});
</script>
