<template>
    <div class="featured-product product">
        <div class="container-fluid">
            <div class="section-header">
                <h1>New Hot Products</h1>
            </div>
            <div class="row align-items-center product-slider product-slider-4">
                <div class="col" v-for="product in products" :key="product.id">
                <Product :product="product"></Product>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import {onBeforeMount, ref, nextTick , onUpdated} from "vue";
import { basicStore } from "../../store/basic";
const basic = basicStore;
import Product from "./Product.vue";
import axios from "axios";
const sliderRef = ref('.product-slider-4'); // Ref to the slider element
const products = ref([])
onBeforeMount(()=>{
    axios.get(`${basic.serverUrl}/api/latest-products?featured=1`)
        .then(res => {
            products.value = res.data.data
        });
})
onUpdated(() => {
    //nextTick(() => {
    //if ($(sliderRef.value).length > 0) {
    $(function () {
        // Product Slider 4 Column
        $(sliderRef.value).slick({
            autoplay: true,
            infinite: true,
            dots: false,
            slidesToShow: 4,
            slidesToScroll: 1,
            responsive: [
                {
                    breakpoint: 1200,
                    settings: {
                        slidesToShow: 4,
                    }
                },
                {
                    breakpoint: 992,
                    settings: {
                        slidesToShow: 3,
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 2,
                    }
                },
                {
                    breakpoint: 576,
                    settings: {
                        slidesToShow: 1,
                    }
                },
            ]
        });
    })
   // }
    //})
});
</script>

<style scoped>

</style>
