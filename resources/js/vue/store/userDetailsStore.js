import { defineStore } from "pinia";


export const useUserDetailsStore = defineStore({
    id: 'userDetails',
    state: () => ({
        user: {}
    }),
    actions: {
        setUserDetails(userDetails) {
            this.user = userDetails;
        },
        getUserDetails() {
            return this.user;
        }
    }
});
