import axios from "axios";
window.axios = axios;

window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";
window.axios.defaults.withCredentials = true;
window.axios.interceptors.response.use(
    (response) => response,
    (error) => {
        if (error.response?.status === 401 || error.response?.status === 419) {
            if (JSON.parse(localStorage.getItem("loggedIn"))) {
                localStorage.setItem("loggedIn", false);
                location.assign("/login");
            }
        }

        return Promise.reject(error);
    }
);
