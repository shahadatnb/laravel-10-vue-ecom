<template>
    <div class="header-slider normal-slider">
        <div v-for="slide in slides" :key="slide.id" class="header-slider-item">
            <img :src="slide.image" :alt="slide.title" />
        </div>
    </div>
</template>

<script setup>
import {ref, onBeforeMount, onUpdated, nextTick } from "vue";
import { basicStore } from "../../store/basic";
const basic = basicStore;
import axios from "axios";
const sliderRef = ref('.header-slider'); // Ref to the slider element
const slides = ref({})
onBeforeMount(() => {
    axios.get(`${basic.serverUrl}/api/posts?post_type=slide`)
    .then(res => {
        //console.log(res.data)
        slides.value = res.data.data
    });
})

onUpdated(()=>{
    //nextTick(() => {
        //if ($(sliderRef.value).length > 0) {
        $(function () {
            // Header slider
            $(sliderRef.value).slick({
                autoplay: true,
                dots: true,
                infinite: true,
                slidesToShow: 1,
                slidesToScroll: 1
            });
        });
       // }
    //})
})
</script>

<style scoped>

</style>
