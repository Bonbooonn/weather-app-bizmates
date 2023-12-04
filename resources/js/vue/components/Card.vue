<script setup>
import { defineProps } from 'vue';

const props = defineProps({
    placeWeather: {
        type: Object,
        required: true
    }
});

</script>
<template>
    <div class="flex flex-wrap">
        <div class="w-full px-2">
            <div
                class="bg-gray-900 text-white relative min-w-0 break-words rounded-lg overflow-hidden shadow-sm mb-4 w-full dark:bg-gray-600 lg:h-96 h-full">
                <div class="absolute top-0 right-0 m-2 z-40">
                    <button type="button" @click.stop="$emit('remove-place', placeWeather.id)"
                        class="text-red-500 w-8 text-md cursor-pointer bg-slate-200 p-1 rounded-full hover:bg-slate-500">
                        &times;
                    </button>
                </div>
                <div class="px-6 py-6 relative">
                    <div class="flex mb-4 justify-between items-center">
                        <div>
                            <h5 class="mb-0 font-medium text-xl">{{ placeWeather.name }}</h5>
                            <h6 class="mb-0">{{ placeWeather.today.date }}</h6>
                            <small>{{ placeWeather.today.weather }}</small>
                        </div>
                        <div class="text-right">
                            <h3 class="font-bold text-4xl mb-0 flex">
                                <span>{{ placeWeather.today.temp.temp }}&deg;

                                </span>
                                <img :src="placeWeather.today.icon" class="inline-block w-8 h-8 mr-2" />
                            </h3>
                        </div>
                    </div>
                    <div class="block sm:flex justify-between items-center flex-wrap">
                        <div class="w-full sm:w-1/2">
                            <div class="flex mb-2 justify-between items-center">
                                <span>Temp</span>
                                <small class="px-2 inline-block">
                                    {{ placeWeather.today.temp.temp }}&nbsp;&deg;
                                </small>
                            </div>
                        </div>
                        <div class="w-full sm:w-1/2">
                            <div class="flex mb-2 justify-between items-center">
                                <span>Feels like</span>
                                <small class="px-2 inline-block">
                                    {{ placeWeather.today.temp.feels_like }}&nbsp;&deg;
                                </small>
                            </div>
                        </div>
                        <div class="w-full sm:w-1/2">
                            <div class="flex mb-2 justify-between items-center">
                                <span>Temp min</span>
                                <small class="px-2 inline-block">
                                    {{ placeWeather.today.temp.temp_min }}&nbsp;&deg;
                                </small>
                            </div>
                        </div>
                        <div class="w-full sm:w-1/2">
                            <div class="flex mb-2 justify-between items-center">
                                <span>Temp max</span>
                                <small class="px-2 inline-block">
                                    {{ placeWeather.today.temp.temp_max }}&nbsp;&deg;
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="divider table mx-2 text-center bg-transparent whitespace-nowrap">
                    <span class="inline-block px-3">
                        <small>Forecast</small>
                    </span>
                </div>
                <div class="px-6 py-6 relative">
                    <div class="text-center justify-between items-center flex" style="flex-flow: initial;">

                        <template v-for="forecast in placeWeather.forecast" :key="forecast.timestamp+forecast.date">
                            <div class="text-center mb-0 flex items-center justify-center flex-col">
                                <span class="block my-1">{{ forecast.day }}</span>
                                <img :src="forecast.icon" class="block w-8 h-8">
                                <span class="block my-1">{{ forecast.temp.temp }}&deg;</span>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
