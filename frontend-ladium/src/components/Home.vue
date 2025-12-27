<script setup>
import Banner from './homepage/Banner.vue'
//import Testimonial from './homepage/Testimonial.vue'
import Categories from './homepage/Categories.vue'
import LoopProduct from './LoopProduct.vue';
import {onMounted,ref} from "vue";
import { basicStore } from "../store/basic";
const basic = basicStore;
import axios from "axios";
const newArarival = ref([])
const recomendedProducts = ref([])

onMounted(async () => {
  try {
    // দুটি API কল একসাথে শেষ হওয়ার জন্য অপেক্ষা করবে
    await Promise.all([
      axios.get(`${basic.serverUrl}/api/latest-products?take=12`).then(res => {
        newArarival.value = res.data.data;
      }),
      axios.get(`${basic.serverUrl}/api/latest-products?featured=1&take=12`).then(res => {
        recomendedProducts.value = res.data.data;
      })
    ]);

    // ডেটা লোড নিশ্চিত হওয়ার পর ফাংশন কল
    pushToDataLayer();
    
  } catch (error) {
    console.error("Error loading products:", error);
  }
});

const pushToDataLayer = () => {
  window.dataLayer = window.dataLayer || [];
  window.dataLayer.push({
    event: "view_item_list",
    ecommerce: {
      items: newArarival.value.map(item => ({
        item_id: item.id,
        item_name: item.title,
        price: item.price,
      }))
    }
  });
};

function loadMoreRecomended() {
  let skip = recomendedProducts.value.length;
    axios.get(`${basic.serverUrl}/api/latest-products?featured=1&take=12&skip=${skip}`)
        .then(res => {
          recomendedProducts.value = [...recomendedProducts.value, ...res.data.data]
    })
}

function loadMoreNew() {
  let skip = newArarival.value.length;
    axios.get(`${basic.serverUrl}/api/latest-products?take=12&skip=${skip}`)
        .then(res => {
          newArarival.value = [...newArarival.value, ...res.data.data]
    })
}

</script>
<template>
    
    <Banner />

    <section class="bg-[#e2e8eb] py-12 product__section">
        <div class="container-fluid mx-auto px-5">
          <div>
            <h3
              class="text-primary text-2xl lg:text-4xl text-center pb-2 border-b border-b-[#d2c7c7] before:content-[''] before:absolute before:-bottom-[.1875rem] before:left-1/2 before:transform before:-translate-x-1/2 before:w-[15%] before:h-[.375rem] before:bg-primary before:z-10 relative before:!bg-[#d6d1d1]"
            >NEW <span class="font-semibold">ARRIVALS</span>
            </h3>
          </div>
          <div class="grid grid-cols-2 xl:grid-cols-6 gap-3 mt-10 gap-y-[32px]">            
            <LoopProduct v-for="product in newArarival" :key="product.id" :product="product"  />
          </div>
        </div>
        <div  v-if="recomendedProducts.length>0" class="viewAllButton text-center pt-10">
          <button type="button" class="px-4 py-2 font-semibold text-sm bg-cyan-500 text-white rounded-full shadow-sm mx-auto"  @click="loadMoreNew()">Load More</button>
        </div>
      </section>
    <!-- ./new arrival -->

    <section class="bg-[#e2e8eb] py-12 product__section">
        <div class="container-fluid mx-auto px-5">
          <div>
            <h3
              class="text-primary text-2xl lg:text-4xl text-center pb-2 border-b border-b-[#d2c7c7] before:content-[''] before:absolute before:-bottom-[.1875rem] before:left-1/2 before:transform before:-translate-x-1/2 before:w-[15%] before:h-[.375rem] before:bg-primary before:z-10 relative before:!bg-[#d6d1d1]"
            >FEATURED <span class="font-semibold">PRODUCTS</span>
            </h3>
          </div>
        <div class="grid grid-cols-2 xl:grid-cols-6 gap-3 mt-10 gap-y-[32px]">
            <LoopProduct v-for="product in recomendedProducts" :key="product.id" :product="product"  />
        </div>
        
        </div>
        <div  v-if="recomendedProducts.length>0" class="viewAllButton text-center pt-10">
          <button type="button" class="px-4 py-2 font-semibold text-sm bg-cyan-500 text-white rounded-full shadow-sm mx-auto"  @click="loadMoreRecomended()">Load More</button>
        </div>
    </section>
    <!-- ./product -->

    <!-- TOP CATEGORIES -->
    <Categories />
         
</template>