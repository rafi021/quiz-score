import { ref, reactive, inject } from "vue";
import { useRouter } from "vue-router";

export default function useAuth() {
    const processing = ref(false);
    const validationErrors = ref({});
    const swal = inject("$swal");
    const router = useRouter();
    const registerForm = reactive({
        name: "",
        email: "",
        password: "",
        remember: false,
    });
    const loginForm = reactive({
        email: "",
        password: "",
        remember: false,
    });

    const user = reactive({
        name: "",
        email: "",
        isAdmin: false,
    });

    const submitRegister = async () => {
        if (processing.value) return;

        processing.value = true;
        validationErrors.value = {};

        axios
            .post("/register", registerForm)
            .then(async (response) => {
                router.push({ name: "login" });
                loginUser(response);
            })
            .catch((error) => {
                if (error.response?.data) {
                    validationErrors.value = error.response.data.errors;
                }
            })
            .finally(() => (processing.value = false));
    };

    const submitLogin = async () => {
        if (processing.value) return;

        processing.value = true;
        validationErrors.value = {};

        axios
            .post("/login", loginForm)
            .then(async (response) => {
                loginUser(response);
            })
            .catch((error) => {
                if (error.response?.data) {
                    validationErrors.value = error.response.data.errors;
                }
            })
            .finally(() => (processing.value = false));
    };

    const loginUser = (response) => {
        user.name = response.data.name;
        user.email = response.data.email;
        user.isAdmin = response.data.is_admin;
        localStorage.setItem("loggedIn", JSON.stringify(true));
        router.push({ name: "quiz.index" });
    };
    const getUser = () => {
        axios.get("/api/user").then((response) => {
            loginUser(response);
        });
    };
    const logout = async () => {
        if (processing.value) return;

        processing.value = true;

        axios
            .post("/logout")
            .then((response) => router.push({ name: "login" }))
            .catch((error) => {
                swal({
                    icon: "error",
                    title: error.response.status,
                    text: error.response.statusText,
                });
            })
            .finally(() => {
                processing.value = false;
            });
    };

    return {
        loginForm,
        registerForm,
        validationErrors,
        processing,
        submitLogin,
        submitRegister,
        user,
        getUser,
        logout,
    };
}
