<script setup>
import { ref, watch, inject } from 'vue';
import api from '../../http/api';
import utils from '../../utils';

const searchInput = ref('');
const searchedPlaces = ref([]);
let places = inject('places');

const fetchPlaces = async (query) => {
    if (!query) {
        searchedPlaces.value = [];
        return;
    }

    query = query.trim();

    const response = await api.get(`/places?search=${query}`);

    searchedPlaces.value = response.data.data;
};

const debounceFetchPlaces = utils.debounce(fetchPlaces, 500);

const addPlace = (place) => {

    places.value = place;
    searchInput.value = '';
    searchedPlaces.value = [];
}

watch(searchInput, (newValue) => {
    debounceFetchPlaces(newValue);
});

</script>
<template>
    <form autocomplete="off" action="#" method="GET" class="p-4 border-b lg:p-0 lg:border">
        <!-- ... search input form as before ... -->
        <label for="search" class="sr-only">Search</label>
        <div class="relative">
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd"
                        d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z"
                        clip-rule="evenodd"></path>
                </svg>
            </div>
            <input id="search" v-model="searchInput"
                class="block w-full rounded-full border-0 bg-white py-1.5 pl-10 pr-3 text-gray-900 ring-gray-300 focus:outline-none placeholder:text-gray-400 sm:text-sm sm:leading-6"
                placeholder="Search" type="search">

            <ul class="absolute left-0 right-0 bg-white mt-1 border border-gray-300 rounded-md shadow-lg z-50"
                v-if="searchedPlaces.length > 0">
                <li v-for="item in searchedPlaces" :key="item.id" @click="addPlace(item)"
                    class="px-4 py-2 hover:bg-gray-100 cursor-pointer">
                    {{ item.name }}
                </li>
            </ul>
        </div>
    </form>
</template>
