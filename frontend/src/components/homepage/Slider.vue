<template>
    <div class="header-slider normal-slider">
        <div class="header-slider-item">
            <img src="img/slider-1.jpg" alt="Slider Image" />

        </div>
        <div class="header-slider-item">
            <img src="img/slider-2.jpg" alt="Slider Image" />

        </div>
        <div class="header-slider-item">
            <img src="img/slider-3.jpg" alt="Slider Image" />

        </div>
    </div>
</template>

<script setup>
import {onMounted} from "vue";
onMounted(()=>{
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
