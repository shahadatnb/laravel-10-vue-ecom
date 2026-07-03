<script setup>
import {ref, onBeforeMount } from "vue";
import { basicStore } from "../../store/basic";
const basic = basicStore;
import axios from "axios";
const sliderRef = ref('.header-slider'); // Ref to the slider element
const slides = ref({})
onBeforeMount(() => {
    axios.get(`${basic.serverUrl}/api/posts?post_type=slide&take=1`)
    .then(res => {
        //console.log(res.data)
        slides.value = res.data.data
    });
})

</script>
<template>
    <!-- banner -->
    <template v-for="slide in slides" :key="slide.id">
    <div class="bg-cover bg-no-repeat bg-center py-36" :style="{ backgroundImage: `url(${slide.image})` }">
        <!-- <div class="container">
            <h1 v-html="slide.title" class="text-6xl text-gray-800 font-medium mb-4 capitalize"></h1>
            <div v-html="slide.body"></div>
        </div> -->
    </div>
    </template>
    <!-- ./banner -->
</template>