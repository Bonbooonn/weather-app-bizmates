import api from "../http/api";

const utils = {
    debounce(fn, delay) {
        let timeoutId;
        return (...args) => {
            clearTimeout(timeoutId);
            timeoutId = setTimeout(() => {
                fn(...args);
            }, delay);
        };
    },

    storeAuthToken(token) {
        localStorage.setItem('apiToken', token);
    },

    getAuthToken() {
        return localStorage.getItem('apiToken');
    },

    removeToken(name) {
        localStorage.removeItem(name);
    },

    async validateToken(token) {
        try {
            const response = await api.get('validate-token', {
                headers: {
                    'Authorization': `Bearer ${token}`
                }
            });

            if (response.status === 200) {
                return response;
            } else {
                throw new Error("Invalid token");
            }
        } catch (err) {
            throw err;
        }
    }
};

export default utils;
