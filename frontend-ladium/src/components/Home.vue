<script setup>
import Banner from './homepage/Banner.vue'
//import Testimonial from './homepage/Testimonial.vue'
import Categories from './homepage/Categories.vue'
import LoopProduct from './LoopProduct.vue';
import {onBeforeMount,ref} from "vue";
import { basicStore } from "../store/basic";
const basic = basicStore;
import axios from "axios";
const newArarival = ref([])
const recomendedProducts = ref([])
onBeforeMount(()=>{
    axios.get(`${basic.serverUrl}/api/latest-products?take=10`)
        .then(res => {
            newArarival.value = res.data.data
        });

    axios.get(`${basic.serverUrl}/api/latest-products?featured=1&take=10`)
        .then(res => {
            recomendedProducts.value = res.data.data
        });
})
</script>
<template>
    
    <Banner />

    <section class="bg-[#e2e8eb] py-12 product__section">
        <div class="container-fluid mx-auto px-5">
          <div>
            <h3
              class="text-primary text-4xl lg:text-4xl text-center pb-10 border-b border-b-[#d2c7c7] before:content-[''] before:absolute before:-bottom-[.1875rem] before:left-1/2 before:transform before:-translate-x-1/2 before:w-[15%] before:h-[.375rem] before:bg-primary before:z-10 relative before:!bg-[#d6d1d1]"
            >
              NEW ARRIVALS
            </h3>
          </div>
          <div class="grid grid-cols-2 xl:grid-cols-6 gap-3 mt-10 gap-y-[32px]">            
            <LoopProduct v-for="product in newArarival" :key="product.id" :product="product"  />
          </div>
        </div>
      </section>
    <!-- ./new arrival -->

    <section class="bg-[#e2e8eb] py-12 product__section">
        <div class="container-fluid mx-auto px-5">
          <div>
            <h3
              class="text-primary text-4xl lg:text-4xl text-center pb-10 border-b border-b-[#d2c7c7] before:content-[''] before:absolute before:-bottom-[.1875rem] before:left-1/2 before:transform before:-translate-x-1/2 before:w-[15%] before:h-[.375rem] before:bg-primary before:z-10 relative before:!bg-[#d6d1d1]"
            >
              FEATURED PRODUCTS
            </h3>
          </div>
        <div class="grid grid-cols-2 xl:grid-cols-6 gap-3 mt-10 gap-y-[32px]">
            <LoopProduct v-for="product in recomendedProducts" :key="product.id" :product="product"  />
        </div>
        </div>
    </section>
    <!-- ./product -->

    <!-- TOP CATEGORIES -->
    <Categories />
         
</template>