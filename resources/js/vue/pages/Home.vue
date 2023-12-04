<script setup>
import WeatherCard from '../components/Card.vue';
import AppHeader from '../components/AppHeader.vue';
import api from '../http/api';
import utils from '../utils';
import { useToast } from 'vue-toast-notification';
import { ref, provide, watch, reactive, onBeforeMount } from 'vue';

let places = ref({});
let placesWeather = reactive([]);
const toast = useToast();

watch(places, async (newValue) => {

    const params = {
        lat: newValue.geo.lat,
        long: newValue.geo.long,
        name: newValue.name,
    };

    let response = await api.post('/weather', { ...params });

    let today = response.data.data.filter((item) => {
        return item.today === true;
    });

    let id = response.data.data[0].id;

    let forecast = response.data.data.filter((item) => {
        return item.today === false || item.today === undefined;
    });

    placesWeather.push({
        ...newValue,
        today: today[0],
        forecast: forecast,
        id: id,
    });

}, { deep: true });

const removePlace = async (id) => {

    await api.delete(`/${id}/remove-saved-place/`);

    toast.success('Place removed successfully', {
        position: 'top-right'
    });
    const updatedPlaces = placesWeather.filter((item) => item.id !== id);
    placesWeather.splice(0, placesWeather.length, ...updatedPlaces);


};

onBeforeMount(() => {
    fetchSavedPlaces();
});

const fetchSavedPlaces = async () => {
    let response = await api.get('/saved-places-weather');

    let savedPlaces = response.data.saved_places;

    let savedPlacesWeather = [];
    savedPlaces.forEach((item) => {
        let tmp = {};

        tmp.name = item.name;

        let today = item.weather.filter((item) => {
            return item.today === true;
        });

        let forecast = item.weather.filter((item) => {
            return item.today === false || item.today === undefined;
        });

        savedPlacesWeather.push({
            name: item.name,
            today: today[0],
            forecast: forecast,
            id: item.id,
        })
    });

    placesWeather.push(...savedPlacesWeather);
}

provide('places', places);
</script>
<template>
    <main>
        <AppHeader />

        <div class="p-4 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 lg:gap-0 mx-auto">
            <template v-for="placeWeather in placesWeather" :key="placeWeather.id">
                <WeatherCard :placeWeather="placeWeather" @remove-place="removePlace" />
            </template>
        </div>

    </main>
</template>
