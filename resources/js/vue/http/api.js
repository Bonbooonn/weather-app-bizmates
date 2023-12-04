import axios from 'axios';
import utils from "../utils";

const api = axios.create({
    baseURL: "http://127.0.0.1:8000/api/",
    withCredentials: true,
});

api.interceptors.request.use(
    async (config) => {
        let token = utils.getAuthToken();
        if (token) {
            config.headers['Authorization'] = `Bearer ${token}`;
        }

        config.headers['Accept'] = 'application/json';
        return config;
    },
    (error) => {
        return Promise.reject(error);
    }
);

export default api;
