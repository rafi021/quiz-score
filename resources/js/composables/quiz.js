import { ref, inject } from "vue";
import { useRouter } from "vue-router";

export default function useQuiz() {
    const quizzes = ref({});
    const router = useRouter();
    const validationErrors = ref({});
    const isLoading = ref(false);
    const quiz = ref({});
    const results = ref({});
    const swal = inject("$swal");

    const getQuizzes = async (
        page = 1,
        order_column = "quiz_date",
        order_direction = "desc"
    ) => {
        axios
            .get(
                "/api/quizzes?page=" +
                    page +
                    "&order_column=" +
                    order_column +
                    "&order_direction=" +
                    order_direction
            )
            .then((response) => {
                quizzes.value = response.data.data;
            });
    };

    const getQuiz = async (id) => {
        axios.get("/api/quizzes/" + id).then((response) => {
            quiz.value = response.data.data;
        });
    };

    const storeQuiz = async (quiz) => {
        if (isLoading.value) return;
        isLoading.value = true;
        validationErrors.value = {};
        axios
            .post("/api/quizzes/", quiz)
            .then((response) => {
                router.push({ name: "quiz.index" });
                swal({
                    icon: "success",
                    title: "Data saved successfully",
                });
            })
            .catch((error) => {
                if (error.response?.data) {
                    validationErrors.value = error.response.data.errors;
                    isLoading.value = false;
                }
            });
    };

    const updateQuiz = async (quiz) => {
        if (isLoading.value) return;

        isLoading.value = true;
        validationErrors.value = {};

        axios
            .put("/api/quizzes/" + quiz.id, quiz)
            .then((response) => {
                router.push({ name: "quiz.index" });
                swal({
                    icon: "success",
                    title: "Data saved successfully",
                });
            })
            .catch((error) => {
                if (error.response?.data) {
                    validationErrors.value = error.response.data.errors;
                }
            })
            .finally(() => (isLoading.value = false));
    };

    const deleteQuiz = async (id) => {
        swal({
            title: "Are you sure?",
            text: "You won't be able to revert this action!",
            icon: "warning",
            showCancelButton: false,
            confirmButtonText: "Yes, delete it!",
            confirmButtonColor: "#ef4444",
            timer: 5000,
            timerProgressBar: true,
            reverseButtons: true,
        }).then((result) => {
            if (result.isConfirmed) {
                axios
                    .delete("/api/quizzes/" + id)
                    .then((response) => {
                        getQuizzes();
                        router.push({ name: "quiz.index" });
                        swal({
                            icon: "success",
                            title: "Data deleted successfully",
                        });
                    })
                    .catch((error) => {
                        swal({
                            icon: "error",
                            title: "Something went wrong",
                        });
                    });
            }
        });
    };

    const getResult = async (id) => {
        axios.get("/api/results/" + id).then((response) => {
            results.value = response.data;
        });
    };

    return {
        quizzes,
        quiz,
        results,
        validationErrors,
        isLoading,
        getQuizzes,
        getQuiz,
        storeQuiz,
        updateQuiz,
        deleteQuiz,
        getResult,
    };
}
