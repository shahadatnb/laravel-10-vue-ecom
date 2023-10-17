<template>
    <div class="header-slider normal-slider">
        <div v-for="slide in slides" :key="slide.id" class="header-slider-item">
            <img :src="slide.image" :alt="slide.title" />
        </div>
    </div>
</template>

<script setup>
import {ref, onBeforeMount, onUpdated } from "vue";
import { basicStore } from "../../store/basic";
const basic = basicStore;
import axios from "axios";
const slides = ref({})
onBeforeMount(() => {
    axios.get(`${basic.serverUrl}/api/posts?post_type=slide`)
        .then(res => {
            //console.log(res.data)
            slides.value = res.data.data
        });
})

onUpdated(()=>{
    $(function () {
        // Header slider
        $('.header-slider').slick({
            autoplay: true,
            dots: true,
            infinite: true,
            slidesToShow: 1,
            slidesToScroll: 1
        });
    });
})
</script>

<style scoped>

</style>
