<template>
  <!-- Hero Section -->
  <section class="bg-gray-900 from-indigo-600 to-purple-600 text-white">
    <div class="max-w-7xl mx-auto px-6 py-20 grid md:grid-cols-2 gap-10 items-center">
      
      <div>
        <h1 class="text-4xl md:text-5xl font-bold leading-tight">
          Discover Your Next Favorite Book
        </h1>
        <p class="mt-5 text-lg text-indigo-100">
          Buy academic, fiction, non-fiction, programming, business and self-development books at the best price.
        </p>

        <div class="mt-8 flex flex-col sm:flex-row gap-4">
          <a href="#" class="bg-white text-indigo-600 px-6 py-3 rounded-lg font-semibold text-center hover:bg-gray-100">
            Shop Now
          </a>
          <a href="#" class="border border-white px-6 py-3 rounded-lg font-semibold text-center hover:bg-white hover:text-indigo-600">
            View Categories
          </a>
        </div>
      </div>

      <div class="bg-white/10 rounded-2xl p-6 shadow-lg">
        <div class="bg-white rounded-xl p-6 text-gray-800">
          <h3 class="text-xl font-bold mb-4">Special Offer</h3>
          <p class="text-gray-600 mb-5">
            Get up to <span class="font-bold text-indigo-600">40% OFF</span> on selected books.
          </p>
          <button class="w-full bg-indigo-600 text-white py-3 rounded-lg hover:bg-indigo-700">
            Grab Offer
          </button>
        </div>
      </div>

    </div>
  </section>

  <!-- Search Bar -->
  <section class="max-w-5xl mx-auto px-6 -mt-8 relative z-10">
    <div class="bg-white shadow-lg rounded-xl p-4 flex flex-col md:flex-row gap-4">
      <input 
        type="text" 
        placeholder="Search by book name, author, or category..."
        class="flex-1 border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-indigo-500"
      />
      <button class="bg-indigo-600 text-white px-8 py-3 rounded-lg hover:bg-indigo-700">
        Search
      </button>
    </div>
  </section>

  <!-- Categories -->
  <section class="max-w-7xl mx-auto px-6 py-16">
    <div class="flex items-center justify-between mb-8">
      <h2 class="text-3xl font-bold">Popular Categories</h2>
      <a href="#" class="text-indigo-600 font-medium hover:underline">View All</a>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
      <div class="bg-white p-6 rounded-xl shadow-sm hover:shadow-md transition text-center">
        <div class="text-4xl mb-3">📘</div>
        <h3 class="font-semibold">Academic</h3>
      </div>

      <div class="bg-white p-6 rounded-xl shadow-sm hover:shadow-md transition text-center">
        <div class="text-4xl mb-3">💻</div>
        <h3 class="font-semibold">Programming</h3>
      </div>

      <div class="bg-white p-6 rounded-xl shadow-sm hover:shadow-md transition text-center">
        <div class="text-4xl mb-3">📖</div>
        <h3 class="font-semibold">Fiction</h3>
      </div>

      <div class="bg-white p-6 rounded-xl shadow-sm hover:shadow-md transition text-center">
        <div class="text-4xl mb-3">💼</div>
        <h3 class="font-semibold">Business</h3>
      </div>
    </div>
  </section>

  <!-- Featured Books -->
  <section class="bg-white py-16">
    <div class="max-w-7xl mx-auto px-6">
      
      <div class="flex items-center justify-between mb-8">
        <h2 class="text-3xl font-bold">Featured Books</h2>
        <a href="#" class="text-indigo-600 font-medium hover:underline">See More</a>
      </div>

      <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-8">

        <!-- Book Card -->        

        <Product v-for="product in recomendedProducts" :key="product.id" :product="product"  />     

      </div>
    </div>
  </section>

  <!-- Why Choose Us -->
  <section class="max-w-7xl mx-auto px-6 py-16">
    <h2 class="text-3xl font-bold text-center mb-10">Why Choose a2zcse?</h2>

    <div class="grid md:grid-cols-3 gap-8">
      <div class="bg-white p-8 rounded-xl shadow-sm text-center">
        <div class="text-4xl mb-4">🚚</div>
        <h3 class="font-bold text-xl mb-2">Fast Delivery</h3>
        <p class="text-gray-600">
          Get your favorite books delivered quickly to your doorstep.
        </p>
      </div>

      <div class="bg-white p-8 rounded-xl shadow-sm text-center">
        <div class="text-4xl mb-4">💳</div>
        <h3 class="font-bold text-xl mb-2">Secure Payment</h3>
        <p class="text-gray-600">
          Safe and easy payment system for every customer.
        </p>
      </div>

      <div class="bg-white p-8 rounded-xl shadow-sm text-center">
        <div class="text-4xl mb-4">⭐</div>
        <h3 class="font-bold text-xl mb-2">Best Collection</h3>
        <p class="text-gray-600">
          Explore thousands of books from different categories.
        </p>
      </div>
    </div>
  </section>
</template>

<script setup>
//import LeftSidebar from "./homepage/LeftSidebar.vue";
//import Slider from "./homepage/Slider.vue";
//import HotProduct from "./homepage/HotProduct.vue";
//import AllProducts from "./homepage/AllProducts.vue";
//import Categories from "./homepage/Categories.vue";
//import Review from "./homepage/Review.vue";
import Product from './homepage/Product.vue';
import {onMounted,onBeforeMount,ref,computed, onUpdated} from "vue";
import axios from "axios";
import { basicStore } from "../store/basic";
const basic = basicStore;
const recomendedProducts = ref([])

onBeforeMount(()=>{
    axios.get(`${basic.serverUrl}/api/latest-products?take=4`)
        .then(res => {
            recomendedProducts.value = res.data.data
        });
})

//lebels.value = basic.settings.menus.lebel
/*
onBeforeMount(() => {
    axios.get(`${basic.serverUrl}/api/posts?post_type=offer&take=2`)
      .then(res => {
          //console.log(res.data)
          slides.value = res.data.data
      });
})
*/


</script>

<style scoped>

</style>
