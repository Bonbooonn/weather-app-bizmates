<script setup>
import { ref, reactive } from 'vue';
import { RouterLink, useRouter } from 'vue-router';
import api from '../http/api';
import utils from "../utils";
import { useToast } from 'vue-toast-notification';
import { useTokenStore, useUserDetailsStore } from '../store';

let user = reactive({
    email: '',
    password: '',
});

const router = useRouter();
const toast = useToast();
const isSubmitting = ref(false);
const tokenStore = useTokenStore();
const userDetailsStore = useUserDetailsStore();

const login = async () => {
    isSubmitting.value = true;
    try {
        const response = await api.post('/login', user);

        tokenStore.setApiToken(response.data.token);
        userDetailsStore.setUserDetails(response.data.user);

        // utils.storeAuthToken(response.data.token);
        toast.success(response.data.message, {
            position: 'top-right'
        });

        router.push({ name: 'home' });
    } catch (e) {
        console.log(e);
        toast.error(e.response.data.message, {
            position: 'top-right'
        });
    } finally {
        isSubmitting.value = false;
    }
};

</script>

<template>
    <div class="container mx-auto p-8 flex">
        <div class="max-w-md w-full mx-auto">
            <h1 class="text-4xl text-center mb-12 font-thin">Weather App</h1>

            <div class="bg-white rounded-lg overflow-hidden shadow-2xl">
                <div class="p-8">
                    <form @submit.prevent="login">
                        <div class="mb-5">
                            <label for="email" class="block mb-2 text-sm font-medium text-gray-600">Email</label>

                            <input type="text" v-model="user.email" id="email"
                                class="block w-full p-3 rounded bg-gray-200 border border-transparent focus:outline-none">
                        </div>

                        <div class="mb-5">
                            <label for="password" class="block mb-2 text-sm font-medium text-gray-600">Password</label>

                            <input type="password" v-model="user.password" id="password"
                                class="block w-full p-3 rounded bg-gray-200 border border-transparent focus:outline-none">
                        </div>

                        <button :disabled="isSubmitting" class="w-full p-3 mt-4 bg-indigo-600 text-white rounded shadow"
                            :class="{ 'bg-indigo-200 cursor-not-allowed': isSubmitting }">Login</button>
                    </form>
                </div>

                <div class="flex justify-center p-8 text-sm border-t border-gray-300 bg-gray-100">
                    <RouterLink to="/register" class="font-medium text-indigo-500">Create Account</RouterLink>
                </div>
            </div>
        </div>
    </div>
</template>
