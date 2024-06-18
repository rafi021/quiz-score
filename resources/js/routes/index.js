import { createRouter, createWebHistory } from "vue-router";

import AuthenticatedLayout from "@/layouts/Authenticated.vue";
import GuestLayout from "@/layouts/Guest.vue";
import Login from "@/components/Auth/Login.vue";
import Register from "@/components/Auth/Register.vue";

import QuizIndex from "@/components/Quiz/Index.vue";
import QuizCreate from "@/components/Quiz/Create.vue";
import QuizEdit from "@/components/Quiz/Edit.vue";

import QuestionIndex from "@/components/Question/Index.vue";
import QuestionCreate from "@/components/Question/Create.vue";
import QuestionEdit from "@/components/Question/Edit.vue";

import AttenQuiz from "@/components/Attend/AttenQuiz.vue";
import ResultQuiz from "@/components/Attend/Result.vue";

function auth(to, from, next) {
    if (JSON.parse(localStorage.getItem("loggedIn"))) {
        next();
    }
    next("/login");
}

const routes = [
    {
        path: "/",
        redirect: { name: "login" },
        component: GuestLayout,
        children: [
            {
                path: "/login",
                name: "login",
                component: Login,
            },
            {
                path: "/register",
                name: "register",
                component: Register,
            },
        ],
    },
    {
        component: AuthenticatedLayout,
        beforeEnter: auth,
        children: [
            {
                path: "/quiz",
                name: "quiz.index",
                component: QuizIndex,
                meta: { title: "Quiz" },
            },
            {
                path: "/quiz/create",
                name: "quiz.create",
                component: QuizCreate,
                meta: { title: "Add New Quiz" },
            },
            {
                path: "/quiz/edit/:id",
                name: "quiz.edit",
                component: QuizEdit,
                meta: { title: "Edit Quiz" },
            },
            {
                path: "/question",
                name: "question.index",
                component: QuestionIndex,
                meta: { title: "Question" },
            },
            {
                path: "/question/create",
                name: "question.create",
                component: QuestionCreate,
                meta: { title: "Add New Question" },
            },
            {
                path: "/question/edit/:id",
                name: "question.edit",
                component: QuestionEdit,
                meta: { title: "Edit Question" },
            },
            {
                path: "/attend-quiz/:quizId",
                name: "attend-quiz",
                component: AttenQuiz,
                meta: { title: "Attend quiz" },
            },
            {
                path: "/result-quiz/:quizId",
                name: "result-quiz",
                component: ResultQuiz,
                meta: { title: "Result quiz" },
            },
        ],
    },
];

export default createRouter({
    history: createWebHistory(),
    routes,
});
