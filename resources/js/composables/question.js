import { ref, inject } from "vue";
import { useRouter } from "vue-router";
export default function useQuestion() {
    const questions = ref({});
    const router = useRouter();
    const validationErrors = ref({});
    const isLoading = ref(false);
    const question = ref({});
    const swal = inject("$swal");

    const getQuestions = async (
        page = 1,
        order_column = "created_at",
        order_direction = "desc"
    ) => {
        axios
            .get(
                "/api/questions?page=" +
                    page +
                    "&order_column=" +
                    order_column +
                    "&order_direction=" +
                    order_direction
            )
            .then((response) => {
                questions.value = response.data.data;
            });
    };

    const getQuestion = async (id) => {
        axios.get("/api/questions/" + id).then((response) => {
            question.value = response.data.data;
        });
    };

    const storeQuestion = async (question) => {
        axios
            .post("/api/questions", question)
            .then((response) => {
                router.push({ name: "question.index" });
            })
            .catch((error) => {
                if (error.response?.data) {
                    validationErrors.value = error.response.data.errors;
                }
            });
    };

    const updateQuestion = async (question) => {
        if (isLoading.value) return;

        isLoading.value = true;
        validationErrors.value = {};

        axios
            .put("/api/questions/" + question.id, question)
            .then((response) => {
                router.push({ name: "question.index" });
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

    const deleteQuestion = async (id) => {
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
                    .delete("/api/questions/" + id)
                    .then((response) => {
                        getQuestion();
                        router.push({ name: "question.index" });
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

    return {
        questions,
        question,
        validationErrors,
        isLoading,
        getQuestions,
        getQuestion,
        storeQuestion,
        updateQuestion,
        deleteQuestion,
    };
}
