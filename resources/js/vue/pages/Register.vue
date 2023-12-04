<script setup>
import { reactive } from 'vue';
import { RouterLink, useRouter } from 'vue-router';
import api from '../http/api';
import { useToast } from 'vue-toast-notification';
import { useTokenStore, useUserDetailsStore } from '../store';

let user = reactive({
    email: '',
    password: '',
    password_confirmation: '',
    name: ''
});

const toast = useToast();
const router = useRouter();
const tokenStore = useTokenStore();
const userDetailsStore = useUserDetailsStore();

const registerUser = async () => {

    try {
        const response = await api.post('/register', user);

        toast.success(response.data.message, {
            position: 'top-right'
        });

        tokenStore.setApiToken(response.data.token);
        userDetailsStore.setUserDetails(response.data.user);

        router.push({ name: 'home' });
    } catch (e) {
        toast.error(e.response.data.message, {
            position: 'top-right'
        });
    }
}

</script>

<template>
    <div class="container mx-auto p-8 flex">
        <div class="max-w-md w-full mx-auto">
            <h1 class="text-4xl text-center mb-12 font-thin">Weather App</h1>

            <div class="bg-white rounded-lg overflow-hidden shadow-2xl">
                <div class="p-8">
                    <form @submit.prevent="registerUser">
                        <div class="mb-5">
                            <label for="name" class="block mb-2 text-sm font-medium text-gray-600">Name</label>

                            <input type="text" v-model="user.name" id="name"
                                class="block w-full p-3 rounded bg-gray-200 border border-transparent focus:outline-none">
                        </div>

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

                        <div class="mb-5">
                            <label for="password_confirm" class="block mb-2 text-sm font-medium text-gray-600">Confirm
                                Password</label>

                            <input type="password" v-model="user.password_confirmation" id="password_confirm"
                                class="block w-full p-3 rounded bg-gray-200 border border-transparent focus:outline-none">
                        </div>

                        <button type="submit"
                            class="w-full p-3 mt-4 bg-indigo-600 text-white rounded shadow">Register</button>
                    </form>
                </div>

                <div class="flex justify-center p-8 text-sm border-t border-gray-300 bg-gray-100">
                    <RouterLink to="/login" class="font-medium text-indigo-500">Login</RouterLink>
                </div>
            </div>
        </div>
    </div>
</template>
