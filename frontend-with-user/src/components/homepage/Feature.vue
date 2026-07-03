<script setup>
import {ref, onBeforeMount } from "vue";
import { basicStore } from "../../store/basic";
const basic = basicStore;
import axios from "axios";
const slides = ref({})
onBeforeMount(() => {
    axios.get(`${basic.serverUrl}/api/posts?post_type=feature&take=3`)
    .then(res => {
        //console.log(res.data)
        slides.value = res.data.data
    });
})

</script>
<template>
    <!-- features -->
    <div class="container py-16">
        <div class="w-10/12 grid grid-cols-1 md:grid-cols-3 gap-6 mx-auto justify-center">
            <template v-for="slide in slides" :key="slide.id">
            <div class="border border-primary rounded-sm px-3 py-6 flex justify-center items-center gap-5">
                <img :src="slide.image" alt="Delivery" class="w-12 h-12 object-contain">
                <div>
                    <h4 class="font-medium capitalize text-lg">{{ slide.title }}</h4>
                    <p class="text-gray-500 text-sm" v-html="slide.body"></p>
                </div>
            </div>
        </template>
        </div>
    </div>
    <!-- ./features -->
</template>