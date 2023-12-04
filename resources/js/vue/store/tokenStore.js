import { defineStore } from 'pinia';

export const useTokenStore = defineStore({
    id: 'apiToken',
    state: () => ({
        apiToken: localStorage.getItem('apiToken') || ''
    }),
    actions: {
        setApiToken(token) {
            this.apiToken = token;
            localStorage.setItem('apiToken', token);
        },
        getAPiToken() {
            return this.apiToken;
        },
        removeApiToken() {
            this.apiToken = '';
            localStorage.removeItem('apiToken');
        }
    }
});
