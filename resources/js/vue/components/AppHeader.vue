<script setup>
import Search from '../components/forms/Search.vue';
import api from '../http/api';
import utils from "../utils";
import { ref, onMounted, onBeforeUnmount, inject, provide } from 'vue';
import { useRouter } from 'vue-router';
import { useTokenStore, useUserDetailsStore } from '../store';

const isOpen = ref(false);
const dropdown = ref(null);
const sidebar = ref(null);
const router = useRouter();
const tokenStore = useTokenStore();
const userDetailsStore = useUserDetailsStore();
const userDetails = userDetailsStore.getUserDetails();

const toggleDropdown = event => {
    isOpen.value = !isOpen.value;
};

const isSidebarOpen = ref(false);

const clickOutside = (event) => {
    if (dropdown.value && !dropdown.value.contains(event.target)) {
        isOpen.value = false;
    }

    if (sidebar.value && !sidebar.value.contains(event.target) && isSidebarOpen.value) {
        isSidebarOpen.value = false;
    }
};

const logout = async () => {
    try {
        await api.post('/logout');
        tokenStore.removeApiToken();
    } catch (e) {
        console.log(e);
    } finally {
        router.push({ name: 'login' });
    }
};

onMounted(() => {
    window.addEventListener('click', clickOutside);
});

onBeforeUnmount(() => {
    window.removeEventListener('click', clickOutside);
});

// provide('places', places);
</script>
<template>
    <main class="w-full bg-white z-50 p-2 flex">
        <!-- Burger Menu Button on Mobile -->
        <button class="lg:hidden md:hidden p-2 hover:bg-slate-100 focus:bg-slate-100"
            @click.stop="isSidebarOpen = !isSidebarOpen">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
            </svg>
        </button>

        <div class="flex lg:flex-start justify-center lg:ml-20 mx-auto">
            <h1 class="text-2xl font-bold">Weather App</h1>
        </div>

        <div ref="sidebar" class="absolute top-0 left-0 w-3/4 bg-gray-100 h-screen lg:hidden z-50" v-show="isSidebarOpen"
            @click.self="isSidebarOpen = false">
            <!-- Search Input -->
            <Search />

            <!-- User Settings with Dropdown -->
            <div class="p-4 border-b">
                <!-- ... user settings with dropdown as before ... -->
                <a class="block w-full px-4 py-2 text-left text-sm leading-5 text-gray-700 ring-black hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out"
                    href="#" @click.prevent="logout">
                    Log Out
                </a>
            </div>
        </div>

        <div class="hidden lg:flex md:flex flex-1 items-center justify-center px-2 lg:ml-6 lg:justify-end">
            <div class="w-full max-w-lg lg:max-w-xs">
                <Search />
            </div>
        </div>

        <div class="hidden lg:ml-3 lg:flex lg:items-center">
            <div class="relative" @click="toggleDropdown" ref="dropdown">
                <button
                    class="flex rounded-full border-2 border-transparent text-sm transition focus:border-gray-300 focus:outline-none">
                    <img class="h-8 w-8 rounded-full object-cover" src="https://placehold.co/600x400" />
                </button>

                <div v-if="isOpen" class="w-48 origin-top-right right-0 absolute z-50 mt-2 rounded-md shadow-lg"
                    @click="isOpen = false">
                    <div class="py-1 bg-white rounded-md ring-1 ring-black ring-opacity-5">
                        <p class="block px-4 py-2">{{ userDetails.name }}</p>
                        <div class="block px-4 py-2 text-xs text-gray-400">
                            Manage Account
                        </div>
                        <a class="block w-full px-4 py-2 text-left text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out"
                            href="#" @click.prevent="logout">
                            Log Out
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </main>
</template>
